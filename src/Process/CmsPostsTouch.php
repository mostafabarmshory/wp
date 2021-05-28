<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

/**
 * Pars and check all params
 *
 * @author maso
 *        
 */
class CmsPostsTouch
{

    public function __invoke(UnitTrackerInterface $unitTracker,CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->print("Touch contents");

        $params = new SearchParams();
        $params->perPage = 20;
        $collection = $distCms->postCollection();
        $it = $sourceCms->postCollection()->find($params);
        $index = 0;
        while ($it->valid()) {
            $post = $it->next();
            $collection->performTransaction($post, 'touch', []);

            $index ++;
            $output->print(".");
        }
        $output->println(".");
        return $unitTracker->next();
    }
}

