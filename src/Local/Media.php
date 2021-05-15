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
    
    /**
     * 
     * {@inheritDoc}
     * @see \Pluf\WP\ItemInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setOrigin(MediaInterface $data)
    {
        $this->data['origin'] = $data->getData();
        // Update content
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::setName()
     */
    public function setName(string $name): self
    {
        $this->data['name'] = $name;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getName()
     */
    public function getName(): string
    {
        return $this->data['name'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        return $this->data['origin'];
    }
}

