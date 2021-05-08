<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\CategoryInterface;

class Category implements CategoryInterface
{

    public CategoryCollection $categoryCollection;

    public $data = null;

    public function __construct($categoryCollection, $data)
    {
        $this->categoryCollection = $categoryCollection;
        $this->data = $data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CategoryInterface::getId()
     */
    public function getId(): ?string
    {
        return $this->data['id'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CategoryInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CategoryInterface::getData()
     */
    public function getData(): array
    {
        return $this->data;
    }
}

