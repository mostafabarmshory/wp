<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\MediaInterface;

class Media implements MediaInterface
{
    
    /**
     * Creates new instance
     *
     * @param PostCollection $postCollection
     * @param array $data
     */
    public function __construct($postCollection, $data)
    {
        $this->postCollection = $postCollection;
        $this->data = $data;
    }
    
    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getId()
     */
    public function getId(): string
    {
        return $this->data['id'];
    }
    
    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getData()
     */
    public function getData(): array
    {
        return $this->data;
    }
}

