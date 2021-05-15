<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsClonePosts
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->print("Getting start to clone posts");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $postCollection  = $distCms->postCollection();
        $index = 0;
        while ($it->valid()) {
            $post = $it->next();
            $tpost = $postCollection->getById($post->getId());
            if(isset($tpost)){
                // Post exist we break the loop
                break;
            } else {
                $tpost = $postCollection->put($post);
            }
            $index ++;

            // if vebose
            $output->print(".");
        }
        $output->println("[ok]");
        return $unitTracker->next();
    }
}

