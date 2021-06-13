<?php
namespace Pluf\Tests\WP\Process;

use PHPUnit\Framework\TestCase;
use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\PostCollectionInterface;
use Pluf\WP\PostInterface;
use Pluf\WP\Cli\Output;
use Pluf\WP\Process\CmsPostsUpload;
use ArrayIterator;

class CmsPostsUploadTest extends TestCase
{

    // public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)

    /**
     *
     * @test
     */
    public function getModifDateTest()
    {
        $resultExp = 'ok';

        // Create a stub for the SomeClass class.
        $unitTracker = $this->createStub(UnitTrackerInterface::class);
        $unitTracker->method('next')
            ->willReturn($resultExp);

        $sourcePost = $this->createStub(PostInterface::class);
        $sourcePost->method('getUploadDate')
            ->willReturn('2020-01-01 00:10:00');
        $sourcePost->method('getModifDate')
            ->willReturn('2020-01-01 00:00:00');
            
        $sourcePostCollection = $this->createStub(PostCollectionInterface::class);
        $sourcePostCollection->method('getCount')
            ->willReturn(1);
        $sourcePostCollection->method('find')
            ->willReturn(new ArrayIterator([$sourcePost]));
        
        // Source cms
        $sourceCms = $this->createStub(CmsAbstract::class);
        $sourceCms->method('postCollection')
            ->willReturn($sourcePostCollection);

            
        $distPost = $this->createStub(PostInterface::class);
        $distPost->method('getUploadDate')
            ->willReturn('2020-01-01 00:10:00');
        $distPost->method('getModifDate')
            ->willReturn('2020-01-01 00:00:00');
            
        // Dist post collection
        $distPostCollection = $this->createStub(PostCollectionInterface::class);
        $distPostCollection->method('getByName')
            ->willReturn($distPost);
        $distPostCollection->expects($this->never())
            ->method('update');
            
        // dist cms
        $distCms = $this->createStub(CmsAbstract::class);
        $distCms->method('postCollection')
            ->willReturn($distPostCollection);
        
        $output = $this->createStub(Output::class);

        $uploadProcess = new CmsPostsUpload();
        $result = $uploadProcess($unitTracker, $sourceCms, $distCms, $output);
        $this->assertEquals($resultExp, $result);
    }
}

