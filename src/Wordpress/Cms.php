<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\CmsAbstract;
use Pluf\WP\MediaCollectionInterface;
use Pluf\WP\PostCollectionInterface;

class Cms extends CmsAbstract
{

    public string $url;

    public $auth;

    public MediaCollection $mediaCollection;
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
        // Init Media
        $this->mediaCollection = new MediaCollection($this);
        $this->mediaCollection->init();

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
    {
        return $this->mediaCollection;
    }
}

