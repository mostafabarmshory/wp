<?php
namespace Pluf\WP\Local;

use Pluf\WP\PostInterface;

class Post implements PostInterface
{

    public $data;

    public $id;

    public PostCollection $postCollection;

    public function __construct(PostCollection $postCollection, $id, $data = [])
    {
        $this->postCollection = $postCollection;
        $this->id = $id;
        $this->data = $data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getId()
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Pluf\WP\ItemInterface::getData()
     */
    public function getData(): array
    {
        return $this->data;
    }
    
    public function setOrigin(PostInterface $data) {
        $this->data['origin'] = $data->getData();
        // Update content
    }
}

