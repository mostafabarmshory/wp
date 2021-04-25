<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;
use Pluf\WP\PostInterface;

/**
 * Pars and check all params
 *
 * @author maso
 *        
 */
class CmsUpdatePostsCanonicalLink
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, string $canonicalLinkPrefix = null, Output $output)
    {
        if (! empty($canonicalLinkPrefix)) {
            $output->println("Setting canonical link");
            $params = new SearchParams();
            $params->perPage = 20;
            $it = $sourceCms->postCollection()->find($params);
            $index = 0;
            while ($it->valid()) {
                $post = $it->next();
                $post->setMeta('link.canonical', $canonicalLinkPrefix . "/" . $post->getName());
                $sourceCms->postCollection()->update($post);

                $index ++;
                // if vebose
                $output->println("[$index]" . $post->getId() . " Is updated with canonical link");
            }
            $output->println("Finish the update canonical");
        }
        return $unitTracker->next();
    }
}

