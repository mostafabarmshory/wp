<?php
namespace Pluf\WP\Std;

use GuzzleHttp\Exception\ClientException;
use Pluf\WP\AssertTrait;
use Pluf\WP\PostCollectionInterface;
use Pluf\WP\PostInterface;
use Pluf\WP\SearchParams;
use Iterator;
use GuzzleHttp\Exception\GuzzleException;
use Pluf\WP\Utils;

class PostCollection implements PostCollectionInterface
{
    use AssertTrait;

    public Cms $parent;

    public function __construct(Cms $parent)
    {
        $this->parent = $parent;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::init()
     */
    public function init()
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::getById()
     */
    public function getById($id): ?PostInterface
    {
        return $this->getByName($id);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::update()
     */
    public function update(PostInterface $post): PostInterface
    {
        $this->assertTrue($post instanceof Post, 'Input must be {{type}} but is {{alt}}', [
            'type' => Post::class,
            'alt' => get_class($post)
        ]);

        // TODO:
        if ($post->dataDerty) {
            $this->saveData($post);
        }

        if ($post->metasDerty) {
            $this->saveMetas($post);
        }

        if ($post->contentDerty) {
            $this->saveContent($post);
        }
        return $post;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::put()
     */
    public function put(PostInterface $post): PostInterface
    {
        // 1- create the contetn
        try {
            $response = $this->parent->request('POST', 'cms/contents', [
                'form_params' => Utils::postToForm($post)
            ]);
            $code = $response->getStatusCode();
        } catch (GuzzleException $ex) {
            $code = $ex->getCode();
        }
        $this->assertTrue($code >= 200 && $code < 300, 'Fail to get content {{name}} from {{url}}', [
            'url' => $this->parent->url,
            'name' => $post->getName()
        ]);
        $data = json_decode($response->getBody(), true);
        $npost = new Post($this, $data, $post->getContent(), $post->getMetas());
        $this->saveContent($npost);
        $this->saveMetas($npost);
        return $npost;
    }

    /**
     * Gets post by its name
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::getByName()
     */
    public function getByName(string $name): ?PostInterface
    {
        $data = $this->fetchData($name);
        if (empty($data)) {
            return null;
        }
        $content = $this->fetchContent($name);
        $metas = $this->fetchMetas($name);
        $post = new Post($this, $data, $content, $metas);
        return $post;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::performTransaction()
     */
    public function performTransaction(PostInterface $post, string $transactionName, array $params = []): PostInterface
    {
        $params['action'] = $transactionName;
        $response = $this->parent->request('POST', 'cms/contents/' . $post->getName() . '/transitions', [
            'form_params' => $params
        ]);
        $code = $response->getStatusCode();
        $this->assertTrue($code >= 200 && $code < 300, 'Fail to peform transaction {{transactionName}} on content {{name}} ', [
            'name' => $post->getName(),
            'transactionName' => $transactionName
        ]);
        return $post;
    }

    // ------------------------------------------------------ Save --------------------------------------
    private function saveData(Post $post)
    {
        $response = $this->parent->request('POST', 'cms/contents/' . $post->getId(), [
            'form_params' => Utils::postToForm($post)
        ]);
        $code = $response->getStatusCode();
        $this->assertTrue($code >= 200 && $code < 300, 'Fail to get content {{name}} from {{url}}', [
            'url' => $this->parent->url,
            'name' => $post->getName()
        ]);
        $data = json_decode($response->getBody(), true);
        $post->setData($data);
        $post->dataDerty = false;
    }

    private function saveMetas(Post $post)
    {
        $metas = $post->getMetas();
        foreach ($metas as $key => $value) {
            $this->parent->request('POST', 'cms/contents/' . $post->getId() . '/metas', [
                'form_params' => [
                    'key' => $key,
                    'value' => $value
                ]
            ]);
        }
        $post->metasDerty = false;
    }

    private function saveContent(Post $post)
    {
        // 2- upload content
        $response = $this->parent->request('POST', 'cms/contents/' . $post->getId() . '/content', [
            'headers' => [
                'Content-Type' => 'text/html',
                'Accept' => 'application/json'
            ],
            'body' => $post->getContent()
        ]);
        $data = json_decode($response->getBody(), true);
        $post->setData($data);
        $post->contentDerty = false;
    }

    // ------------------------------------------------------ fetch --------------------------------------
    /**
     * Fetch information form server
     *
     * @param string $name
     * @return NULL|mixed
     */
    private function fetchData(string $name)
    {
        try {
            $response = $this->parent->request('GET', 'cms/contents/' . $name);
            $code = $response->getStatusCode();
        } catch (ClientException $ex) {
            $code = $ex->getCode();
        }
        if ($code > 399 && $code < 500) {
            return null;
        }

        $this->assertTrue($code >= 200 && $code < 300, 'Fail to get content {{name}} from {{url}}', [
            'url' => $this->parent->url,
            'name' => $name
        ]);

        $data = json_decode($response->getBody(), true);
        return $data;
    }

    private function fetchMetas(string $name): array
    {
        $response = $this->parent->request('GET', 'cms/contents/' . $name . '/metas');
        $metasArray = json_decode($response->getBody(), true);
        $metasArray = $metasArray['items'];
        if (! is_array($metasArray)) {
            $metasArray = [];
        }
        $metas = [];
        foreach ($metasArray as $item) {
            $metas[$item['key']] = $item['value'];
        }
        return $metas;
    }

    private function fetchContent(string $name): string
    {
        try {
            $response = $this->parent->request('GET', 'cms/contents/' . $name . '/content');
            $content = $response->getBody();
        } catch (\Throwable $e) {
            $content = "";
        }
        return $content;
    }
}

