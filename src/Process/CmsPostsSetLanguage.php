<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsSetLanguage  extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, ?string $updateLanguage = null)
    {
        
        $params = new SearchParams();
        $params->perPage = 20;
        $sourcePostCollection = $sourceCms->postCollection();
        $this->setTitle("Update Description")
            ->setDescription("Generate a new description from the content")
            ->setTotalSteps($sourcePostCollection->getCount($params))
            ->setOutput($output)
            ->start();
        if (!empty($updateLanguage)) {
            $it = $sourcePostCollection->find($params);
            while ($it->valid()) {
                $post = $it->current();
                $it->next();
    
                // check language change and updagte
                $oldLanguage = $post->getMeta('language');
                if($oldLanguage != $updateLanguage){
                    $post->setMeta('language', $updateLanguage)
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

