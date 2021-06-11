<?php
namespace Pluf\WP\Local;

use Pluf\WP\PostInterface;

class Post implements PostInterface
{

    public $data;

    public $id;

    public PostCollection $postCollection;

    public bool $derty;

    /**
     * Creates new instance of local post
     *
     * @param PostCollection $postCollection
     * @param mixed $id
     * @param array $data
     */
    public function __construct(PostCollection $postCollection, $id, $data = [])
    {
        $this->derty = false;
        $this->postCollection = $postCollection;
        $this->id = $id;
        $this->data = $data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::isDerty()
     */
    public function isDerty(): bool
    {
        return $this->derty;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setDerty()
     */
    public function setDerty(bool $derty): self
    {
        $this->derty = $derty;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\ItemInterface::getId()
     */
    public function getId()
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
     * @see \Pluf\WP\ItemInterface::setData()
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Pluf\WP\ItemInterface::setOrigin()
     */
    public function setOrigin(PostInterface $data): self
    {
        return $this->setProperty('origin', $data);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        return $this->getProperty('origin');
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setContent()
     */
    public function setContent(string $content): self
    {
        return $this->setProperty('content', $content);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getContent()
     */
    public function getContent(): ?string
    {
        return $this->getProperty('content');
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setName()
     */
    public function setName(string $name): self
    {
        return $this->setProperty('name', $name);
        ;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getName()
     */
    public function getName(): string
    {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $name = md5($this->postCollection->parent->baseDir) . '-' . $this->id;
            $this->setName($name);
        }
        return $name;
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
     * @see \Pluf\WP\PostInterface::setMimeType()
     */
    public function setMimeType(string $mimeType): self
    {
        return $this->setProperty('mime_type', $mimeType);
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
     * @see \Pluf\WP\PostInterface::getFIleName()
     */
    public function getFIleName(): ?string
    {
        return $this->getProperty('file_name');
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
     * @see \Pluf\WP\PostInterface::setTitle()
     */
    public function setTitle(string $title): self
    {
        return $this->setProperty('title', $title);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setTitle()
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
        return $this->getProperty('modif_dtime', gmdate("Y-m-d H:i:s"));
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setModifDate()
     */
    public function setModifDate(string $date = null): self
    {
        if (empty($date)) {
            $date = gmdate("Y-m-d H:i:s");
        }
        return $this->setProperty('modif_dtime', $date);
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
        return $this->getProperty('description');
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setUploadDate()
     */
    public function setUploadDate(string $date = null): self
    {
        if (empty($date)) {
            $datetime = new \DateTime(null, new \DateTimeZone('UTC'));
            $datetime->modify('+5 minutes');
            $date = $datetime->format("Y-m-d H:i:s");
        }
        return $this->setProperty('upload_dtime', $date);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getUploadDate()
     */
    public function getUploadDate(): string
    {
        return $this->getProperty('upload_dtime', '');
    }

    // ------------------------------------------------Properties----------------------------
    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setProperty()
     */
    public function setProperty(string $key, $value): self
    {
        $oldValue = $this->getProperty($key);
        if ($oldValue != $value) {
            $this->data[$key] = $value;
            $this->setDerty(true);
        }
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getProperty()
     */
    public function getProperty(string $key, $default = null)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return $default;
    }

    // ---------------------------------------------------- metas ---------------------------

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
        
        $oldValue = null;
        if (array_key_exists($key, $this->data['metas'])) {
           $oldValue = $this->data['metas'][$key];
        }
        
        if($oldValue == $value){
            return $this;
        }
        
        $this->data['metas'][$key] = $value;
        $this->setDerty(true);
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMetas()
     */
    public function getMetas(): array
    {
        if (! array_key_exists('metas', $this->data)) {
            $this->data['metas'] = [];
        }
        return $this->data['metas'];
    }
}

