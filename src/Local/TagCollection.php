<?php
namespace Pluf\WP\Local;

use Pluf\WP\AssertTrait;
use Pluf\WP\SearchParams;
use Pluf\WP\TagsCollectionInterface;
use Iterator;

class TagCollection implements TagsCollectionInterface
{

    use AssertTrait;

    private $parent;

    /**
     * Creates new instance of local collection
     *
     * @param Cms $parent
     */
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
    {
        $parent = $this->parent;
        $baseDir = $parent->getPath();

        // ckech base dir
        $this->assertIsDir($baseDir, 'Storage directory {{baseDir}} not exist.', [
            'baseDir' => $baseDir
        ]);

        // create repo
        $pathname = $this->getPath();
        $this->assertTrue(is_dir($pathname) || mkdir($pathname), 'Impossilbe to create tags directory {{pathname}} for local cms.', [
            'pathname' => $pathname
        ]);
    }

    public function getPath(): string
    {
        return $this->parent->getPath() . '/tags';
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {}
}

