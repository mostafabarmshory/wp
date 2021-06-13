<?php
namespace Pluf\Tests\WP\Local;

use PHPUnit\Framework\TestCase;
use Pluf\WP\Local;

class CmsUpdateTimeTest extends TestCase
{

    public function testUpdateTime()
    {
        $cms = new Local\Cms('test-data', '.');
        $cms->init();

        $id = 'testpost-' . rand();
        $post = new Local\Post($cms->postCollection(), $id);
        $this->assertNotNull($post);
        $this->assertFalse($post->isDerty());

        $post->setTitle('title')
            ->setContent('<h1>Hi</h1>  ')
            ->setDescription('description')
            ->setFileName('fileName')
            ->setMediaType('mediaType')
            ->setMimeType('text/html');
        $this->assertTrue($post->isDerty());

        $post = $cms->postCollection()->put($post);
        $this->assertNotNull($post);
        $this->assertFalse($post->isDerty());

        $newPost = $cms->postCollection()->getById($post->getId());
        $this->assertNotNull($newPost);
        $this->assertFalse($newPost->isDerty());

        $upTime = $newPost->getModifDate();
        $newPost->setContent('<h1>Hi</h1>  ');
        $newPost = $cms->postCollection()->update($newPost);
        $newPost = $cms->postCollection()->getById($post->getId());

        $this->assertEquals($upTime, $newPost->getModifDate());
    }
}

