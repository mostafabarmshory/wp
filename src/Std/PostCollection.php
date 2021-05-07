<?php
namespace Pluf\WP\Std;

use GuzzleHttp\Exception\ClientException;
use Pluf\WP\AssertTrait;
use Pluf\WP\PostCollectionInterface;
use Pluf\WP\PostInterface;
use Pluf\WP\SearchParams;
use Iterator;
use GuzzleHttp\Exception\GuzzleException;

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

    public function getById($id): ?PostInterface
    {}

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
                'form_params' => $this->postToForm($post)
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
        $npost = new Post($this, $data);

        // 2- upload content
        $response = $this->parent->request('POST', 'cms/contents/' . $npost->getId() . '/content', [
            'headers' => [
                'Content-Type' => 'text/html',
                'Accept' => 'application/json'
            ],
            'body' => $post->getContent()
        ]);
        $this->assertTrue($code >= 200 && $code < 300, 'Fail to load content value of {{name}} from {{url}}', [
            'url' => $this->parent->url,
            'name' => $post->getName()
        ]);
        $data = json_decode($response->getBody(), true);
        $npost = new Post($this, $data);

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
        $post = new Post($this, $data);
        return $post;
    }

    private function postToForm(PostInterface $post): array
    {
        return [
            'name' => $post->getName(),
            'title' => $post->getTitle(),
            'description' => $post->getDescription(),
            'file_name' => $post->getFIleName(),
            'media_type' => $post->getMediaType(),
            'mime_type' => $post->getMimeType()
        ];
    }
}

