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
class CmsUpdatePostsCanonicalLink extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, string $canonicalLinkPrefix = null, Output $output)
    {
        $srcPostCollection = $sourceCms->postCollection();
        $params = new SearchParams();
        $params->perPage = 20;
        $this->setTitle("Upload Posts")
            ->setDescription("Upload and update remote posts")
            ->setOutput($output)
            ->setTotalSteps($srcPostCollection->getCount($params))
            ->start();

        if (! empty($canonicalLinkPrefix)) {
            $it = $srcPostCollection->find($params);
            while ($it->valid()) {
                // update canonical link
                $post = $it->current();
                $it->next();

                $oldValue = $post->getMeta('link.canonical');
                $newValue = $canonicalLinkPrefix . "/" . $post->getName();
                if ($oldValue != $newValue) {
                    $post->setMeta('link.canonical', $newValue)
                        ->setModifDate();
                    $srcPostCollection->update($post);
                }
                // next step
                $this->stepComplete();
            }
        }
        $this->done();
        return $unitTracker->next();
    }
}

