<?php
namespace Pluf\Tests\WP\Wordpress;

use PHPUnit\Framework\TestCase;
use Pluf\WP\Wordpress\Post;
use Pluf\WP\Wordpress\PostCollection;
use Pluf\WP\Wordpress\Cms;

class PostTest extends TestCase
{

    /**
     * @test
     */
    public function getModifDateTest()
    {
        $data = array(
            'id' => 4491,
            'date' => '2021-04-07T14:50:12',
            'date_gmt' => '2021-04-07T10:20:12',
            'guid' => array(
                'rendered' => 'https://blog.nobitex.ir/?p=4491'
            ),
            'modified' => '2021-04-08T12:52:01',
            'modified_gmt' => '2021-04-08T08:22:01',
            'slug' => 'how-to-draw-trendline',
            'status' => 'publish',
            'type' => 'post',
            'link' => 'https://blog.nobitex.ir/how-to-draw-trendline/',
            'title' => array(
                'rendered' => 'A rendered title'
            ),
            'content' => array(
                'rendered' => '<p>test</p>',
                'protected' => false
            ),
            'excerpt' => array(
                'rendered' => '<p',
                'protected' => false
            ),
            'author' => 1,
            'featured_media' => 4495,
            'comment_status' => 'closed',
            'ping_status' => 'open',
            'sticky' => false,
            'template' => '',
            'format' => 'standard',
            'meta' => array(),
            'categories' => array(
                0 => 19
            ),
            'tags' => array(
                0 => 109,
                1 => 69,
                2 => 159,
                3 => 74,
                4 => 137
            )
        );
        $date = '2021-04-08 08:22:01';
        
        $parent = new Cms('https://blog.elbaan.com', null);
        $postCollection = new PostCollection($parent);
        $post = new Post($postCollection, $data);
        
        $mdDate = $post->getModifDate();
        $this->assertNotNull($mdDate);
        $this->assertEquals($date, $mdDate);
        $this->assertTrue($date == $mdDate);
        $this->assertTrue('2021-04-08 08:20:01' < $mdDate);
    }
}

