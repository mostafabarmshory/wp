<?php
namespace Pluf\WP\Local;

use Pluf\WP\AssertTrait;
use Pluf\WP\CmsAbstract;
use Pluf\WP\MediaCollectionInterface;
use Pluf\WP\PostCollectionInterface;
use Pluf\WP\TagsCollectionInterface;

class Cms extends CmsAbstract
{

    use AssertTrait;

    public string $id;

    public string $baseDir;

    public MediaCollection $mediaCollection;

    public PageCollection $pageCollection;

    public PostCollection $postCollection;

    public TagCollection $tagCollection;

    public CategoryCollection $categoryCollection;

    public CommentCollection $commentCollection;

    public function __construct(string $id, string $baseDir = '.')
    {
        $this->id = $id;
        $this->baseDir = $baseDir;
    }

    /**
     * Init the storage
     */
    public function init()
    {
        // ckech base dir
        $this->assertIsDir($this->baseDir, 'Storage directory {{baseDir}} not exist.', [
            'baseDir' => $this->baseDir
        ]);

        // create repo
        $pathname = $this->getPath();
        if (! is_dir($this->id)) {
            mkdir($pathname);
        }
        $this->assertIsDir($pathname, 'Impossilbe to create directory {{pathname}} for local cms.', [
            'pathname' => $pathname
        ]);

        // Init Media
        $this->mediaCollection = new MediaCollection($this);
        $this->mediaCollection->init();

        // init pages
        $this->pageCollection = new PageCollection($this);
        $this->pageCollection->init();

        // init post
        $this->postCollection = new PostCollection($this);
        $this->postCollection->init();

        // TagsCollection.php
        $this->tagCollection = new TagCollection($this);
        $this->tagCollection->init();

        // init CategoryCollection
        $this->categoryCollection = new CategoryCollection($this);
        $this->categoryCollection->init();

        // init CommentCollection
        $this->commentCollection = new CommentCollection($this);
        $this->commentCollection->init();
    }

    public function getPath(): string
    {
        return $this->baseDir . '/' . $this->id;
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::tagCollection()
     */
    public function tagCollection(): TagsCollectionInterface
    {
        return $this->tagCollection;
    }
}

