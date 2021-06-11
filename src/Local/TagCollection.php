<?php
namespace Pluf\WP\Local;

use Pluf\WP\AssertTrait;
use Pluf\WP\SearchParams;
use Pluf\WP\TagInterface;
use Pluf\WP\TagsCollectionInterface;
use Iterator;

class TagCollection implements TagsCollectionInterface
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
        $this->assertTrue(is_dir($pathname) || mkdir($pathname), 'Impossilbe to create tags directory {{pathname}} for local cms.', [
            'pathname' => $pathname
        ]);
    }

    public function getPath(): string
    {
        return $this->parent->getPath() . '/tags';
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {
        return new TagIterator($this, $params);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\TagsCollectionInterface::getById()
     */
    public function getById($id): ?TagInterface
    {
        $post = new Tag($this, $id);
        $path = $this->getPath() . '/' . $post->getId();
        // Get the contents of the JSON file
        if (! is_file($path)) {
            return null;
        }
        $strJsonFileContents = file_get_contents($path);
        // Convert to array
        $data = json_decode($strJsonFileContents, true);
        if (! isset($data)) {
            throw new \RuntimeException("File content is not correct for tag id:" . $id);
        }
        $post->setData($data);
        return $post;
    }

    public function update(TagInterface $post): TagInterface
    {}

    public function put(TagInterface $post): TagInterface
    {
        // TODO: check if file exist
        // create new post
        $newPost = new Tag($this, $post->getId());
        $newPost->setOrigin($post);
        $this->save($newPost);
        return $newPost;
    }
    
    
    
    /**
     * save the post
     *
     * @param Post $post
     */
    private function save(Tag $post)
    {
        $path = $this->getPath() . '/' . $post->getId();
        $myfile = fopen($path, "w");
        $post->setModifDate();
        $data = $post->getData();
        fwrite($myfile, json_encode($data));
        fclose($myfile);
    }
    public function getCount(SearchParams $params): int
    {}

}

