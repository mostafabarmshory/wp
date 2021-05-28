<?php
namespace Pluf\WP\Local;

use Pluf\WP\AssertTrait;
use Pluf\WP\PostCollectionInterface;
use Pluf\WP\SearchParams;
use Iterator;
use Pluf\WP\PostInterface;

class PostCollection implements PostCollectionInterface
{

    use AssertTrait;

    public Cms $parent;

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
        return $this->parent->getPath() . '/posts';
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\CollectionInterface::find()
     */
    public function find(SearchParams $params): Iterator
    {
        return new PostIterator($this, $params);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::put()
     */
    public function put(PostInterface $post): PostInterface
    {
        // TODO: check if file exist
        // create new post
        $newPost = new Post($this, $post->getId());
        $newPost->setOrigin($post);
        $this->save($newPost);
        return $newPost;
    }

    /**
     * save the post
     *
     * @param Post $post
     */
    private function save(Post $post)
    {
        // generate data
        $post->setModifDate();
        $data = $post->getData();
        $toW = json_encode($data);
        if (JSON_ERROR_NONE != json_last_error()) {
            throw new \RuntimeException("fail to encode content :" . $post->getId() . ' msg:' . json_last_error_msg());
        }

        // write data
        $path = $this->getPath() . '/' . $post->getId();
        $myfile = fopen($path, "w");
        fwrite($myfile, $toW);
        fclose($myfile);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::getById()
     */
    public function getById($id): ?PostInterface
    {
        $post = new Post($this, $id);
        $path = $this->getPath() . '/' . $post->getId();
        // Get the contents of the JSON file
        if (! is_file($path)) {
            return null;
        }
        $strJsonFileContents = file_get_contents($path);
        // Convert to array
        $data = json_decode($strJsonFileContents, true);
        if (JSON_ERROR_NONE != json_last_error()) {
            throw new \RuntimeException("fail to encode content " . $post->getId() . " msg:" . json_last_error_msg());
        }
        if (! isset($data)) {
            $data = [];
        }
        $post->setData($data);
        return $post;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::update()
     */
    public function update(PostInterface $post): PostInterface
    {
        $this->save($post);
        return $post;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::getByName()
     */
    public function getByName(string $name): ?PostInterface
    {
        throw new \RuntimeException("Impossible to get content with name from local");
    }

    /**
     *
     * {@inheritdoc}
     * @see \Pluf\WP\PostCollectionInterface::performTransaction()
     */
    public function performTransaction(PostInterface $post, string $transactionName, array $params = []): PostInterface
    {}
}

