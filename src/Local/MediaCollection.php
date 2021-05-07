<?php
namespace Pluf\WP\Local;

use Pluf\WP\AssertTrait;
use Pluf\WP\MediaCollectionInterface;
use Pluf\WP\MediaInterface;
use Pluf\WP\SearchParams;
use Iterator;

class MediaCollection implements MediaCollectionInterface
{

    use AssertTrait;

    private $parent;

    /**
     * Creates new instance of local collection
     *
     * @param Cms $parent
     */
    public function __construct(Cms $parent)
    {
        $this->parent = $parent;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::init()
     */
    public function init()
    {
        $parent = $this->parent;
        $baseDir = $parent->getPath();

        // ckech base dir
        $this->assertIsDir($baseDir, 'Storage directory {{baseDir}} not exist.', [
            'baseDir' => $baseDir
        ]);

        // create repo
        $pathname = $this->getPath();
        $this->assertTrue(is_dir($pathname) || mkdir($pathname), 'Impossilbe to create medias directory {{pathname}} for local cms.', [
            'pathname' => $pathname
        ]);
    }

    public function getPath(): string
    {
        return $this->parent->getPath() . '/medias';
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {}

    public function put(MediaInterface $media): MediaInterface
    {
        // TODO: check if file exist
        // create new post
        $newMedia = new Media($this, $media->getId());
        $newMedia->setOrigin($media);
        $this->save($newMedia);
        return $newMedia;
    }

    /**
     * save the post
     *
     * @param Post $post
     */
    private function save(Media $media)
    {
        $path = $this->getPath() . '/' . $media->getId();
        $myfile = fopen($path, "w");
        $data = $media->getData();
        fwrite($myfile, json_encode($data));
        fclose($myfile);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\MediaCollectionInterface::getByName()
     */
    public function getByName(string $name): ?MediaInterface
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\MediaCollectionInterface::getById()
     */
    public function getById($id): ?MediaInterface
    {
        $media = new Media($this, $id);
        $path = $this->getPath() . '/' . $media->getId();
        // Get the contents of the JSON file
        if (! is_file($path)) {
            return null;
        }
        $strJsonFileContents = file_get_contents($path);
        // Convert to array
        $data = json_decode($strJsonFileContents, true);
        if (! isset($data)) {
            throw new \RuntimeException("File content is not correct for media id:" . $id);
        }
        $media->setData($data);
        return $media;
    }
}

