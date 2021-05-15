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
class CmsPostSetProperty
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, $propertyKey, $propertyValue)
    {
        $output->print("Setting property of a contetn");

        $params = new SearchParams();
        $params->perPage = 20;
        $collection = $sourceCms->postCollection();
        $it = $collection->find($params);
        $index = 0;
        while ($it->valid()) {
            $post = $it->next();
            $post->setProperty($propertyKey, $propertyValue);
            $collection->update($post);

            $index ++;
            $output->print(".");
        }
        $output->println(".");
        return $unitTracker->next();
    }
}

