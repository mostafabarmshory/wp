<?php
namespace Pluf\WP;

/**
 * A post instance must be loaded.
 *
 * @author maso
 *        
 */
interface PostInterface extends ItemInterface
{

    public function setContent(string $content): self;

    public function getContent(): ?string;

    public function setMeta(string $key, ?string $value = null): self;

    public function getMeta(string $key): ?string;

    public function getMetas(): array;

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

    public function setProperty(string $key, $value): self;
}

