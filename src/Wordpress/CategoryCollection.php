<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\CategoryCollectionInterface;
use Pluf\WP\CategoryInterface;
use Pluf\WP\SearchParams;
use Iterator;

class CategoryCollection implements CategoryCollectionInterface
{

    public Cms $parent;

    /**
     * Creates new instance of the collection
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
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {
        return new CategoryIterator($this, $params);
    }

    public function getById($id): ?CategoryInterface
    {}

    public function update(CategoryInterface $category): CategoryInterface
    {}

    public function put(CategoryInterface $category): CategoryInterface
    {}
    public function getCount(SearchParams $params): int
    {}

}

