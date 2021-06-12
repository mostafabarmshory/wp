<?php
namespace Pluf\WP\Std;

use Pluf\WP\PostInterface;
use Pluf\WP\AbstractPost;

/**
 * A standard post
 *
 * @author maso
 *        
 */
class Post extends AbstractPost implements PostInterface
{

    public PostCollection $parent;

    /**
     * Crates new instance of the post
     *
     * @param PostCollection $parent
     * @param array $data
     */
    public function __construct(PostCollection $parent, array $data = [], $content = null, $metas = [])
    {
        parent::__construct($data);
        $this->parent = $parent;
        $this->setContent($content);
        foreach ($metas as $key => $vlaue) {
            $this->setMeta($key, $vlaue);
        }
        $this->setDerty(false);
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


}

