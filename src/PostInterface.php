<?php
namespace Pluf\WP;

use DateTime;

interface PostInterface extends ItemInterface
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
    
    public function setContent(string $content): self;
    public function getContent(): ?string;

    public function setName(string $name): self;

    public function getName(): string;

    public function setMeta(string $key, ?string $value = null): self;

    public function getMeta(string $key): ?string;
    
    public function setMimeType(string $mimeType): self;
    public function getMimeType(): ?string;
    
    public function setMediaType(string $mediaType): self;
    public function getMediaType(): ?string;
    
    public function setFileName(string $fileName): self;
    public function getFileName(): ?string;
    
    public function setTitle(string $title): self;
    public function getTitle(): ?string;
    
    public function setDescription(string $description): self;
    public function getDescription(): ?string;
    
    public function getModifDate(): string;
}

