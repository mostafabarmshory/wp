<?php
namespace Pluf\WP\Local;

use Iterator;
use Pluf\WP\SearchParams;

class TagIterator implements Iterator
{

    public TagCollection $tagCollection;

    public array $files;

    public int $index;

    public SearchParams $params;

    /**
     * Creates new instance of the iterator
     *
     * @param PostCollection $postCollection
     */
    public function __construct(TagCollection $tagCollection, SearchParams $params)
    {
        $this->params = $params;
        $this->tagCollection = $tagCollection;
        $this->rewind();
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::next()
     */
    public function next()
    {
        $this->index ++;
        return $this->current();
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::valid()
     */
    public function valid()
    {
        return $this->index < count($this->files) - 1;
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::current()
     */
    public function current()
    {
        $path = $this->files[$this->index];
        return $this->tagCollection->getById(basename($path));
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        // load files
        $directory = $this->tagCollection->getPath();
        $this->index = 0;
        $this->files = scandir($directory);
        while (is_dir($this->files[$this->index]) && $this->index < count($this->files)) {
            $this->index ++;
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->index;
    }
}

