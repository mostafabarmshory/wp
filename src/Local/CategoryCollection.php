<?php
namespace Pluf\WP\Local;

use Pluf\WP\AssertTrait;
use Pluf\WP\CategoryCollectionInterface;
use Pluf\WP\CategoryInterface;
use Pluf\WP\SearchParams;
use Iterator;

class CategoryCollection implements CategoryCollectionInterface
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
        $this->assertTrue(is_dir($pathname) || mkdir($pathname), 'Impossilbe to create categories directory {{pathname}} for local cms.', [
            'pathname' => $pathname
        ]);
    }

    public function getPath(): string
    {
        return $this->parent->getPath() . '/categories';
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {
        return new CategoryIterator($this, $params);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\TagsCollectionInterface::getById()
     */
    public function getById($id): ?CategoryInterface
    {
        $post = new Category($this, $id);
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

    public function update(CategoryInterface $post): CategoryInterface
    {}

    public function put(CategoryInterface $post): CategoryInterface
    {
        // TODO: check if file exist
        // create new post
        $newPost = new Category($this, $post->getId());
        $newPost->setOrigin($post);
        $this->save($newPost);
        return $newPost;
    }

    /**
     * save the post
     *
     * @param Post $post
     */
    private function save(Category $post)
    {
        $path = $this->getPath() . '/' . $post->getId();
        $myfile = fopen($path, "w");
        $post->setModifDate();
        $data = $post->getData();
        fwrite($myfile, json_encode($data));
        fclose($myfile);
    }
}