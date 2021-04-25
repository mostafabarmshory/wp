<?php
namespace Pluf\WP;

interface PostCollectionInterface extends CollectionInterface
{

    public function put(PostInterface $post): PostInterface;

    public function update(PostInterface $post): PostInterface;

    public function getById($id): PostInterface;
}

