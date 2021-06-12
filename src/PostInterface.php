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

    public function setContent(?string $content): self;

    public function getContent(): ?string;

    public function setMeta(string $key, ?string $value = null): self;

    public function getMeta(string $key): ?string;

    public function getMetas(): array;

    public function setMimeType(?string $mimeType): self;

    public function getMimeType(): ?string;

    public function setMediaType(?string $mediaType): self;

    public function getMediaType(): ?string;

    public function setFileName(?string $fileName): self;

    public function getFileName(): ?string;

    public function setTitle(?string $title): self;

    public function getTitle(): ?string;

    public function setDescription(?string $description): self;

    public function getDescription(): ?string;

    public function getModifDate(): string;
    public function setModifDate(?string $date = null): self;

    
    /**
     * Set value as the property
     * 
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setProperty(string $key, $value): self;
    
    /**
     * Gets property value
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getProperty(string $key, $default = null);
    
    
    
    public function getUploadDate(): string;
    public function setUploadDate(string $date = null): self;
    
    
    /**
     * Return true if there is a modification in the memory instance
     * 
     * For example you may load a post and then change a propertye of it. Then isDerty returns ture.
     * 
     * @return bool true if there is change in loaded instance
     */
    public function isDerty(): bool;
    
    /**
     * Marks the post as a derty one
     * 
     * @param bool $derty the derty state
     * @return self the post itself
     */
    public function setDerty(bool $derty): self;
}

