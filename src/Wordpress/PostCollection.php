<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\PostCollectionInterface;
use Pluf\WP\PostInterface;
use Pluf\WP\SearchParams;
use Iterator;

class PostCollection implements PostCollectionInterface
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
        return new PostIterator($this, $params);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::put()
     */
    public function put(PostInterface $post): PostInterface
    {
        return null;
    }

    public function getById($id): PostInterface
    {}

    public function update(PostInterface $post): PostInterface
    {}
}

