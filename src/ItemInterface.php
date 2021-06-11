<?php
namespace Pluf\WP;

interface ItemInterface
{
    
    /**
     * Gets the original data
     *
     * Original data is a map of key value based on wordpress data model.
     * The original data is data from original site.
     *
     * Throw exception if original data does not exist any more.
     *
     * @return array
     */
    public function getOrigin(): array;
    public function setOrigin(PostInterface $data): self;
    
    public function getId();

    public function getData(): array;
    public function setData($data): self;
    
    public function setName(string $name): self;
    public function getName(): string;
}

