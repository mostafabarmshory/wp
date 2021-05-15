<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\SearchParams;
use Pluf\WP\TagInterface;
use Pluf\WP\TagsCollectionInterface;
use Iterator;

class TagCollection implements TagsCollectionInterface
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
        return new TagIterator($this, $params);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\TagsCollectionInterface::getById()
     */
    public function getById($id): ?TagInterface
    {}

    public function update(TagInterface $post): TagInterface
    {}

    public function put(TagInterface $post): TagInterface
    {}
}

