<?php
namespace Pluf\WP;

interface CategoryInterface
{
    function getId(): ?string;
    public function getData(): array;
    public function setData($data): self;
}

