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
class CmsPostSetProperty extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, $propertyKey, $propertyValue)
    {
        $output->print("Setting property of a contetn");
        $params = new SearchParams();
        $params->perPage = 20;
        $sourcePostCollection = $sourceCms->postCollection();
        $this->setTitle("Set property")
            ->setDescription("Used to set property to all documents")
            ->setTotalSteps($sourcePostCollection->getCount($params))
            ->setOutput($output)
            ->start();

        $it = $sourcePostCollection->find($params);
        while ($it->valid()) {
            $post = $it->current();
            $it->next();
            
            $oldPropertyValue = $post->setProperty($propertyKey);
            if($oldPropertyValue != $propertyValue){
                $post->setModifDate()
                    ->setProperty($propertyKey, $propertyValue);
                $sourcePostCollection->update($post);
            }
            $this->stepComplete();
        }
        $this->done();
        return $unitTracker->next();
    }
}

