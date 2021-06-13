<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\MediaInterface;
use Pluf\WP\WpException;

class Media implements MediaInterface
{

    public MediaCollection $mediaCollection;

    public $data = null;

    /**
     * Creates new instance
     *
     * @param PostCollection $postCollection
     * @param array $data
     */
    public function __construct($mediaCollection, $data)
    {
        $this->mediaCollection = $mediaCollection;
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::setName()
     */
    public function setName(string $name): self
    {
        throw new WpException("Imposible to set name for a Wordpress post");
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getName()
     */
    public function getName(): string
    {
        return md5($this->getOrigin()) . '-' . $this->getId();
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        $link = $this->data['link'];
        $url = parse_url($link);
        return $url['host'];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Pluf\WP\ItemInterface::setOrigin()
     */
    public function setOrigin($data): self
    {}

}

