<?php
namespace Pluf\WP;

interface PostCollectionInterface extends CollectionInterface
{

    public function put(PostInterface $post): PostInterface;
}

