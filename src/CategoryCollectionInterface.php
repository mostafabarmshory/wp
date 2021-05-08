<?php
namespace Pluf\WP;

interface CategoryCollectionInterface extends CollectionInterface
{
    public function put(CategoryInterface $category): CategoryInterface;
    public function update(CategoryInterface $category): CategoryInterface;
    public function getById($id): ?CategoryInterface;
}

