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
class CmsPostsContentRemoveStyle
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output)
    {
        $output->println("Remove style");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $index = 0;
        while ($it->valid()) {
            $post = $it->next();

            $re = '/style=".*?"/i';
            $content = preg_replace($re, "", $post->getContent());
            $post->setContent($content);
            $sourceCms->postCollection()->update($post);

            $index ++;
            // if vebose
            $output->println("[$index]" . $post->getId() . " ");
        }
        return $unitTracker->next();
    }

}
