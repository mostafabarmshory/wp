<?php
namespace Pluf\WP;

interface MediaCollectionInterface extends CollectionInterface
{

    public function put(MediaInterface $media): MediaInterface;
}

