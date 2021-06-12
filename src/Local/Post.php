<?php
namespace Pluf\WP\Local;

use Pluf\WP\PostInterface;
use Pluf\WP\AbstractPost;

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
}

