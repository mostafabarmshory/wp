<?php
namespace Pluf\WP;

interface TagInterface
{

    function getId(): ?string;
    public function getData(): array;
    public function setData($data): self;
}

