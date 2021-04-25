<?php
namespace Pluf\WP\Std;

use Pluf\WP\CmsAbstract;
use Pluf\WP\MediaCollectionInterface;
use Pluf\WP\PostCollectionInterface;

class Cms extends CmsAbstract
{

    public string $url;

    public $auth;

    /**
     * Creates new instance of the cms
     *
     * @param string $url
     * @param mixed $auth
     */
    public function __construct($url, $auth)
    {
        $this->url = $url;
        $this->auth = $auth;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::init()
     */
    public function init()
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::postCollection()
     */
    public function postCollection(): PostCollectionInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CmsAbstract::mediaCollection()
     */
    public function mediaCollection(): MediaCollectionInterface
    {}
}

