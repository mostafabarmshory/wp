<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\PostInterface;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsClonePosts extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->print("Getting start to clone posts");

        $this->setTitle("Clone Posts")
            ->setDescription("Getting start to clone posts")
            ->setTotalSteps(- 1)
            ->setOutput($output)
            ->start();

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $postCollection = $distCms->postCollection();
        while ($it->valid()) {
            $post = $it->current();
            $it->next();
            $tpost = $postCollection->getById($post->getId());
            if (isset($tpost)) {
                // Post exist we break the loop
                break;
            } else {
                $tpost = $postCollection->newPost($post->getId());
                $tpost->setOrigin($post->getData());
                $tpost->setContent($this->fetchContent($tpost))
                    ->setTitle($this->fetchTitle($tpost))
                    ->setMeta('title', $this->fetchTitle($tpost))
                    ->setMeta('link.favicon', '/imgx/api/v2/cms/contents/favicon/content')
                    ->setMediaType('post')
                    ->setMimeType('text/html')
                    ->setFileName($tpost->getId() . '.html');
                
                $tpost = $postCollection->put($tpost);
            }

            // if vebose
            $this->stepComplete(1);
        }
        $this->done();

        return $unitTracker->next();
    }
    
    
    
    public function fetchContent(PostInterface $post)
    {
        $origin = $post->getOrigin();
        return $origin['content']['rendered'];
    }
    
    public function fetchTitle(PostInterface $post)
    {
        $origin = $post->getOrigin();
        return $origin['title']['rendered'];
    }
}

