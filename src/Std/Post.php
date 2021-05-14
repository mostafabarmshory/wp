<?php
namespace Pluf\WP\Std;

use Pluf\WP\PostInterface;

/**
 * A standard post
 *
 * @author maso
 *        
 */
class Post implements PostInterface
{

    public PostCollection $parent;

    public $data = [];

    public bool $dataDerty = false;

    public $content = null;

    public bool $contentDerty = false;

    public array $metas = [];

    public bool $metasDerty = false;

    /**
     * Crates new instance of the post
     *
     * @param PostCollection $parent
     * @param array $data
     */
    public function __construct(PostCollection $parent, array $data = [], $content = null, $metas = [])
    {
        $this->parent = $parent;

        $this->data = $data;
        $this->dataDerty = false;

        $this->content = $content;
        $this->contentDerty = false;

        $this->metas = $metas;
        $this->metasDerty = false;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setName()
     */
    public function setName(string $name): self
    {
        return $this->setProperty('name', $name);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getName()
     */
    public function getName(): string
    {
        return $this->getProperty('name');
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
        return $this->getProperty('mime_type');
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMimeType()
     */
    public function setMimeType(string $mimeType): self
    {
        return $this->setProperty('mime_type', $mimeType);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setTitle()
     */
    public function setTitle(string $title): self
    {
        return $this->setProperty('title', $title);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMediaType()
     */
    public function setMediaType(string $mediaType): self
    {
        return $this->setProperty('media_type', $mediaType);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMediaType()
     */
    public function getMediaType(): ?string
    {
        return $this->getProperty('media_type');
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getId()
     */
    public function getId()
    {
        return $this->getProperty('id');
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setFileName()
     */
    public function setFileName(string $fileName): self
    {
        return $this->setProperty('file_name', $fileName);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getTitle()
     */
    public function getTitle(): ?string
    {
        return $this->getProperty('title');
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getData()
     */
    public function getData(): array
    {
        return $this->data['creation_dtime'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setDescription()
     */
    public function setDescription(string $description): self
    {
        return $this->setProperty('description', $description);
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

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        $this->dataDerty = false;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setProperty()
     */
    public function setProperty(string $key, $value): self
    {
        $this->data[$key] = $value;
        $this->dataDerty = true;
        return $this;
    }

    public function getProperty(string $key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }

    // ----------------------------------------------- Metas ----------------------------------------------
    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMeta()
     */
    public function getMeta(string $key): ?string
    {
        if (array_key_exists($key, $this->metas)) {
            return $this->metas[$key];
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMeta()
     */
    public function setMeta(string $key, ?string $value = null): self
    {
        $this->metas[$key] = $value;
        $this->metasDerty = true;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMetas()
     */
    public function getMetas(): array
    {
        return $this->metas;
    }

    // ----------------------------------------------- Content ----------------------------------------------

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getContent()
     */
    public function getContent(): ?string
    {
        return $this->content;
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
}

