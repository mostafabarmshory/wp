<?php
namespace Pluf\WP\Wordpress;

use Pluf\WP\AbstractPost;
use Pluf\WP\PostInterface;

class Post  extends AbstractPost implements PostInterface
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
     * @see \Pluf\WP\PostInterface::getOrigin()
     */
    public function getOrigin(): array
    {
        $link = $this->data['link'];
        $url = parse_url($link);
        return $url['host'];
    }


    /**
     * Generates unique name of the content
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::getName()
     */
    public function getName(): string
    {
        return $this->getProperty('name', md5($this->getOrigin()) . '-' . $this->getId());
    }


    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setTitle()
     */
    public function setTitle(?string $title): self
    {
        $this->data["title"]["rendered"] = $title;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostInterface::setMediaType()
     */
    public function setMediaType(?string $mediaType): self
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

}

