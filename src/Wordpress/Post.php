<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\PostInterface;
use Pluf\WP\WpException;

class Post implements PostInterface
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        throw new WpException("Original data not supported for WP driver");
    }

    public function setName(string $name):self
    {}

    public function setContent(string $content):self
    {}

    public function getName(): string
    {}

    public function getMeta(string $key): ?string
    {}

    public function setMeta(string $key, ?string $value = null):self
    {}
}

