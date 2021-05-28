<?php
namespace Pluf\WP;

interface PostCollectionInterface extends CollectionInterface
{
    public function put(PostInterface $post): PostInterface;

    public function update(PostInterface $post): PostInterface;

    public function getById($id): ?PostInterface;

    public function getByName(string $name): ?PostInterface;
    
    public function performTransaction(PostInterface $post, string $transactionName, array $params = []): PostInterface;
}

