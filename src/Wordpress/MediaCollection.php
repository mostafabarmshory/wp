<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\MediaCollectionInterface;
use Pluf\WP\MediaInterface;
use Pluf\WP\SearchParams;
use Iterator;

class MediaCollection implements MediaCollectionInterface
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
        return new MediaIterator($this, $params);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\MediaCollectionInterface::put()
     */
    public function put(MediaInterface $media): MediaInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\MediaCollectionInterface::getByName()
     */
    public function getByName(string $name): ?MediaInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\MediaCollectionInterface::getById()
     */
    public function getById($id): ?MediaInterface
    {}
    public function getCount(SearchParams $params): int
    {}

}

