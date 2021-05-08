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

    public function setOrigin(PostInterface $data): self
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setContent()
     */
    public function setContent(string $content): self
    {
        $this->data['content'] = $content;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getContent()
     */
    public function getContent(): ?string
    {
        return $this->data['content'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setName()
     */
    public function setName(string $name): self
    {
        $this->data['name'] = $name;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getName()
     */
    public function getName(): string
    {
        if (! array_key_exists('name', $this->data)) {
            $name = md5($this->postCollection->parent->baseDir) . '-' . $this->id;
            $this->setName($name);
        }
        return $this->data['name'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMeta()
     */
    public function getMeta(string $key): ?string
    {
        if (! array_key_exists('metas', $this->data)) {
            $this->data['metas'] = [];
        }
        return $this->data['metas'][$key];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMeta()
     */
    public function setMeta(string $key, ?string $value = null): self
    {
        if (! array_key_exists('metas', $this->data)) {
            $this->data['metas'] = [];
        }
        $this->data['metas'][$key] = $value;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMimeType()
     */
    public function getMimeType(): ?string
    {
        return $this->data['mime_type'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMimeType()
     */
    public function setMimeType(string $mimeType): self
    {
        $this->data['mime_type'] = $mimeType;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMediaType()
     */
    public function setMediaType(string $mediaType): self
    {
        $this->data['media_type'] = $mediaType;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMediaType()
     */
    public function getMediaType(): ?string
    {
        return $this->data['media_type'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getFIleName()
     */
    public function getFIleName(): ?string
    {
        return $this->data['file_name'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setFileName()
     */
    public function setFileName(string $fileName): self
    {
        $this->data['file_name'] = $fileName;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setTitle()
     */
    public function setTitle(string $title): self
    {
        $this->data['title'] = $title;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setTitle()
     */
    public function getTitle(): ?string
    {
        return $this->data['title'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getModifDate()
     */
    public function getModifDate(): string
    {
        return $this->data['modif_dtime'];
    }

    public function setModifDate(string $date = null): self
    {
        if (empty($date)) {
            $date = gmdate("Y-m-d H:i:s");
        }
        $this->data['modif_dtime'] = $date;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setDescription()
     */
    public function setDescription(string $description): self
    {
        $this->data['description'] = $description;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getDescription()
     */
    public function getDescription(): ?string
    {
        return $this->data['description'];
    }
}

