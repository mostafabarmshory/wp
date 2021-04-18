<?php
namespace Pluf\WP;

interface ItemInterface
{

    public function getId(): string;

    public function getData(): array;
}

