<?php
namespace Pluf\WP\Wordpress;

use Iterator;

class TagIterator extends AbstractIterator implements Iterator
{

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\Wordpress\AbstractIterator::createNewInstance()
     */
    protected function createNewInstance($data)
    {
        return new Tag($this->parent, $data);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\Wordpress\AbstractIterator::getApi()
     */
    protected function getApi(): string
    {
        return 'wp-json/wp/v2/tags';
    }
}

