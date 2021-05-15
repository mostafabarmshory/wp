<?php
namespace Pluf\WP;

interface MediaCollectionInterface extends CollectionInterface
{

    public function put(MediaInterface $media): MediaInterface;

    public function getById($id): ?MediaInterface;

    public function getByName(string $name): ?MediaInterface;
}

