<?php
namespace Pluf\WP;

abstract class CmsAbstract
{
    public abstract function init();
    public abstract function postCollection(): PostCollectionInterface;
    public abstract function mediaCollection(): MediaCollectionInterface;
}

