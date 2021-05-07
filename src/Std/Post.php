<?php
namespace Pluf\WP\Std;

use Pluf\WP\PostInterface;

class Post implements PostInterface
{

    public PostCollection $parent;

    public $data = null;

    public bool $dataDerty = false;

    public $content = null;

    public bool $contentDerty = false;

    /**
     * Crates new instance of the post
     *
     * @param PostCollection $parent
     * @param array $data
     */
    public function __construct(PostCollection $parent, $data)
    {
        $this->parent = $parent;
        $this->data = $data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setName()
     */
    public function setName(string $name): self
    {
        if (! $this->dataDerty && $name != $this->data['name']) {
            $this->dataDerty = true;
        }
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setContent()
     */
    public function setContent(string $content): self
    {
        if (! $this->contentDerty && $content != $this->content) {
            $this->contentDerty = true;
        }
        $this->content = $content;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getName()
     */
    public function getName(): string
    {
        return $this->data['name'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        $url = parse_url($this->parent->parent->url);
        return $url['host'];
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
     * @see \Pluf\WP\PostInterface::getFileName()
     */
    public function getFileName(): ?string
    {
        return $this->data['file_name'];
    }

    public function getContent(): ?string
    {
        // TODO: maso, download content
    }

    public function setMimeType(string $mimeType): self
    {}

    public function setTitle(string $title): self
    {}

    public function setMeta(string $key, ?string $value = null): self
    {}

    public function setMediaType(string $mediaType): self
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMediaType()
     */
    public function getMediaType(): ?string
    {
        return $this->data['mime_type'];
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

    public function setFileName(string $fileName): self
    {}

    public function getTitle(): ?string
    {}

    public function getMeta(string $key): ?string
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getModifDate()
     */
    public function getModifDate(): string
    {
        return $this->data['modif_dtime'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getData()
     */
    public function getData(): array
    {
        return $this->data['creation_dtime'];
    }

    public function setDescription(string $description): self
    {}

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

