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
        $output->println("Getting start to clone media");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->mediaCollection()->find($params);
        $mediaCollection = $distCms->mediaCollection();
        $index = 0;
        while ($it->valid()) {
            $media = $it->next();

            $tmedia = $mediaCollection->getById($media->getId());
            if ($tmedia) {
                $output->println("Media exists");
                break;
            }
            $tmedia = $mediaCollection->put($media);
            $index ++;

            // if vebose
            $output->println("[$index]" . $media->getId() . " " . $tmedia->getId());
        }
        $output->println("Finish the clone media");
        return $unitTracker->next();
    }
}

