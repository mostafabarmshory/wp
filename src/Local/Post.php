<?php
namespace Pluf\WP\Local;

use Pluf\WP\PostInterface;
use Pluf\WP\AbstractPost;
use Pluf\WP\Process\WordpressUtils;

class Post extends AbstractPost implements PostInterface
{

    public PostCollection $postCollection;

    /**
     * Creates new instance of local post
     *
     * @param PostCollection $postCollection
     * @param mixed $id
     * @param array $data
     */
    public function __construct(PostCollection $postCollection, $id, array $data = [])
    {
        parent::__construct($data);
        $this->setId($id);
        $this->setDerty(false);
        $this->postCollection = $postCollection;
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
            $name = md5($this->postCollection->parent->baseDir) . '-' . $this->getId();
            $this->setName($name);
        }
        return $name;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\AbstractPost::getContent()
     */
    public function getContent(): ?string
    {
        $str = parent::getContent();
        if (empty($str)) {
            $str = WordpressUtils::fetchContent($this);
            $this->setContent($str);
        }
        return $str;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\AbstractPost::getTitle()
     */
    public function getTitle(): ?string
    {
        $str = parent::getTitle();
        if (empty($str)) {
            $str = WordpressUtils::fetchTitle($this);
            $this->setTitle($str);
        }
        return $str;
    }
}

