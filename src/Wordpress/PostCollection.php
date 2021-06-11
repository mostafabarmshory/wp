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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::getByName()
     */
    public function getByName(string $name): ?PostInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::performTransaction()
     */
    public function performTransaction(PostInterface $post, string $transactionName, array $params = []): PostInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::getCount()
     */
    public function getCount(SearchParams $params): int
    {
        return 0;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::newPost()
     */
    public function newPost($id): PostInterface
    {
        return new Post($this, []);
    }
}

