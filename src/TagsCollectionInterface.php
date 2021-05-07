<?php
namespace Pluf\WP;

interface TagsCollectionInterface extends CollectionInterface
{
    public function put(TagInterface $post): TagInterface;
    public function update(TagInterface $post): TagInterface;
    public function getById($id): ?TagInterface;
}

