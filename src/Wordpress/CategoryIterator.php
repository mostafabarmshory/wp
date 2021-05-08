<?php
namespace Pluf\WP\Wordpress;

use Iterator;

class CategoryIterator extends AbstractIterator implements Iterator
{

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\Wordpress\AbstractIterator::createNewInstance()
     */
    protected function createNewInstance($data)
    {
        return new Category($this->parent, $data);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\Wordpress\AbstractIterator::getApi()
     */
    protected function getApi(): string
    {
        return 'wp-json/wp/v2/categories';
    }
}

