<?php
namespace Pluf\WP;

abstract class CmsAbstract
{

    public abstract function init();

    public abstract function postCollection(): PostCollectionInterface;

    public abstract function mediaCollection(): MediaCollectionInterface;

    public abstract function tagCollection(): TagsCollectionInterface;

    public abstract function categoryCollection(): CategoryCollectionInterface;
}

