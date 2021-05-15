<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsCategoryClone
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->println("Getting start to clone categories");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->categoryCollection()->find($params);
        $collection = $distCms->categoryCollection();
        $index = 0;
        while ($it->valid()) {
            $tag = $it->next();

            $ttag = $collection->getById($tag->getId());
            if ($ttag) {
                $output->println("Category exists");
                break;
            }
            $ttag = $collection->put($tag);
            $index ++;

            // if vebose
            $output->println("[$index]" . $tag->getId() . " " . $ttag->getId());
        }
        $output->println("Finish the clone tags");
        return $unitTracker->next();
    }
}

