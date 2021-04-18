<?php
namespace Pluf\WP\Local;

use Pluf\WP\MediaInterface;

class Media implements MediaInterface
{

    public $data;

    public $id;

    public MediaCollection $mediaCollection;

    public function __construct(MediaCollection $mediaCollection, $id, $data = [])
    {
        $this->mediaCollection = $mediaCollection;
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
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getData()
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function setOrigin(MediaInterface $data)
    {
        $this->data['origin'] = $data->getData();
        // Update content
    }
}

