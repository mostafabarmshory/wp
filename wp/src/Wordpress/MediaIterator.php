<?php
namespace Pluf\WP\Wordpress;


class MediaIterator extends AbstractIterator
{
    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\Wordpress\AbstractIterator::createNewInstance()
     */
    protected function createNewInstance($data)
    {
        return new Media($this->parent, $data);
    }
    
    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\Wordpress\AbstractIterator::getApi()
     */
    protected function getApi(): string
    {
        return 'wp-json/wp/v2/media';
    }
}

