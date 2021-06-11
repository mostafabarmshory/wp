<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsMediaClone
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->print("Getting start to clone media");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->mediaCollection()->find($params);
        $mediaCollection = $distCms->mediaCollection();
        $index = 0;
        while ($it->valid()) {
            $media = $it->next();
            if(empty($media)){
                continue;
            }

            $tmedia = $mediaCollection->getById($media->getId());
            if ($tmedia) {
                break;
            }
            $tmedia = $mediaCollection->put($media);
            $index ++;

            // if vebose
            $output->print(".");
        }
        $output->println("[ok]");
        return $unitTracker->next();
    }
}

