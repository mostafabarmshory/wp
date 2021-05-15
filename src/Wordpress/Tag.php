<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\TagInterface;

class Tag implements TagInterface
{

    public TagCollection $tagCollection;

    public $data = null;

    /**
     * Creates new instance
     *
     * @param PostCollection $postCollection
     * @param array $data
     */
    public function __construct($tagCollection, $data)
    {
        $this->tagCollection = $tagCollection;
        $this->data = $data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\TagInterface::getId()
     */
    public function getId(): ?string
    {
        return $this->data['id'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\TagInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\TagInterface::getData()
     */
    public function getData(): array
    {
        return $this->data;
    }
}

