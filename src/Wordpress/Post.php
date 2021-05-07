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
     * @see \Pluf\WP\PostInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        $link = $this->data['link'];
        $url = parse_url($link);
        return $url['host'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setName()
     */
    public function setName(string $name): self
    {
        throw new WpException("Imposible to set name for a Wordpress post");
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setContent()
     */
    public function setContent(string $content): self
    {
        throw new WpException("Imposible to set content for a Wordpress post");
    }

    /**
     * Generates unique name of the content
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getName()
     */
    public function getName(): string
    {
        return md5($this->getOrigin()) . '-' . $this->getId();
    }

    public function getMeta(string $key): ?string
    {}

    public function setMeta(string $key, ?string $value = null): self
    {}

    public function getMimeType(): ?string
    {}

    public function getFIleName(): ?string
    {}

    public function getContent(): ?string
    {}

    public function setMimeType(string $mimeType): self
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setTitle()
     */
    public function setTitle(string $title): self
    {
        $this->data["title"]["rendered"] = $title;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMediaType()
     */
    public function setMediaType(string $mediaType): self
    {
        $this->data['type'] = $mediaType;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getMediaType()
     */
    public function getMediaType(): ?string
    {
        return $this->data['type'];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setFileName()
     */
    public function setFileName(string $fileName): self
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getTitle()
     */
    public function getTitle(): ?string
    {
        return $this->data["title"]["rendered"];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getModifDate()
     */
    public function getModifDate(): string
    {
        $time = $this->data['modified_gmt'];
        $date = gmdate("Y-m-d H:i:s", $this->rest_parse_date($time));
        return $date;
    }

    /**
     * Parses an RFC3339 time into a Unix timestamp.
     *
     * @since 4.4.0
     *       
     * @param string $date
     *            RFC3339 timestamp.
     * @param bool $force_utc
     *            Optional. Whether to force UTC timezone instead of using
     *            the timestamp's timezone. Default false.
     * @return int Unix timestamp.
     */
    function rest_parse_date($date, $force_utc = false)
    {
        if ($force_utc) {
            $date = preg_replace('/[+-]\d+:?\d+$/', '+00:00', $date);
        }

        $regex = '#^\d{4}-\d{2}-\d{2}[Tt ]\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:Z|[+-]\d{2}(?::\d{2})?)?$#';

        $matches = [];
        if (! preg_match($regex, $date, $matches)) {
            return false;
        }

        return strtotime($date);
    }

    public function setDescription(string $description): self
    {}

    public function getDescription(): ?string
    {}
}

