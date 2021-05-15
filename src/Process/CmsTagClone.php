<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsTagClone
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->print("Getting start to clone tag");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->tagCollection()->find($params);
        $tagCollection = $distCms->tagCollection();
        $index = 0;
        while ($it->valid()) {
            $tag = $it->next();

            $ttag = $tagCollection->getById($tag->getId());
            if ($ttag) {
                break;
            }
            $ttag = $tagCollection->put($tag);
            $index ++;

            // if vebose
            $output->print(".");
        }
        $output->println("Finish the clone tags");
        return $unitTracker->next();
    }
}

