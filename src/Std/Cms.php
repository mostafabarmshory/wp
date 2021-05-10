<?php
namespace Pluf\WP\Std;

use GuzzleHttp\Client;
use Pluf\WP\CategoryCollectionInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\MediaCollectionInterface;
use Pluf\WP\PostCollectionInterface;
use Pluf\WP\TagsCollectionInterface;
use Psr\Http\Message\ResponseInterface;

class Cms extends CmsAbstract
{

    public string $url;

    public $auth;

    public ?Client $client = null;

    // public MediaCollection $mediaCollection;
    // public PageCollection $pageCollection;
    public PostCollection $postCollection;

    // public TagCollection $tagCollection;
    // public CategoryCollection $categoryCollection;
    // public CommentCollection $commentCollection;

    /**
     * Creates new instance of the cms
     *
     * @param string $url
     * @param mixed $auth
     */
    public function __construct($url, $auth)
    {
        $this->url = $url;
        $this->auth = $auth;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::init()
     */
    public function init()
    {
        // TODO: maso, 2021: check the token or basic auth
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->url . '/api/v2/',
            // You can set any number of default request options.
            // 'timeout' => 2.0
            'cookies' => true,
            'auth' => [
                $this->auth['login'],
                $this->auth['pass']
            ]
        ]);

        // Init Media
        // $this->mediaCollection = new MediaCollection($this);
        // $this->mediaCollection->init();

        // init pages
        // $this->pageCollection = new PageCollection($this);
        // $this->pageCollection->init();

        // init post
        $this->postCollection = new PostCollection($this);
        $this->postCollection->init();

        // TagsCollection.php
        // $this->tagCollection = new TagCollection($this);
        // $this->tagCollection->init();

        // init CategoryCollection
        // $this->categoryCollection = new CategoryCollection($this);
        // $this->categoryCollection->init();

        // init CommentCollection
        // $this->commentCollection = new CommentCollection($this);
        // $this->commentCollection->init();
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::postCollection()
     */
    public function postCollection(): PostCollectionInterface
    {
        return $this->postCollection;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::mediaCollection()
     */
    public function mediaCollection(): MediaCollectionInterface
    {}

    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string $method
     *            HTTP method.
     * @param string $uri
     *            URI object or string.
     * @param array $options
     *            Request options to apply. See \GuzzleHttp\RequestOptions.
     *            
     * @throws \Exception
     */
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::tagCollection()
     */
    public function tagCollection(): TagsCollectionInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::categoryCollection()
     */
    public function categoryCollection(): CategoryCollectionInterface
    {}
}

