<?php
namespace Pluf\WP\Std;

use Pluf\WP\CmsAbstract;
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

    public function postCollection(): PostCollectionInterface
    {}
}

