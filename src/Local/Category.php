<?php
namespace Pluf\WP\Local;

use Pluf\WP\CategoryInterface;

class Category implements CategoryInterface
{

    public $data;

    public $id;

    public CategoryCollection $categoryCollection;

    public function __construct(CategoryCollection $categoryCollection, $id, $data = [])
    {
        $this->categoryCollection = $categoryCollection;
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
     * {@inheritdoc}
     * @see \Pluf\WP\TagInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setModifDate(string $date = null): self
    {
        if (empty($date)) {
            $date = gmdate("Y-m-d H:i:s");
        }
        $this->data['modif_dtime'] = $date;
        return $this;
    }

    public function setOrigin(CategoryInterface $data): self
    {
        $this->data['origin'] = $data->getData();
        // Update content
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        return $this->data['origin'];
    }
}

