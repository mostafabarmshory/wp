<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsSetTemplate extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, ?string $updateTemplate = null)
    {
        $output->print("Setting template of posts");
        
        $params = new SearchParams();
        $params->perPage = 20;
        $sourcePostCollection = $sourceCms->postCollection();
        $this->setTitle("Setting Template")
            ->setDescription("Setting template of posts")
            ->setTotalSteps($sourcePostCollection->getCount($params))
            ->setOutput($output)
            ->start();
        

        if (!empty($updateTemplate)) {
            $it = $sourcePostCollection->find($params);
            while ($it->valid()) {
                $post = $it->current();
                $it->next();
    
                $oldValue = $post->getMeta('template');
                if($oldValue != $updateTemplate){
                    $post->setMeta('template', $updateTemplate)
                        ->setModifDate();
                    $sourcePostCollection->update($post);
                }
                $this->stepComplete();
            }
        }
        $this->done();
        return $unitTracker->next();
    }
}

