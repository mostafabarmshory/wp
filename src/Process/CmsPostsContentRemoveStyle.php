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
class CmsPostsContentRemoveStyle extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output)
    {
        $params = new SearchParams();
        $params->perPage = 20;
        $sourcePostCollection = $sourceCms->postCollection();
        $this->setTitle("Remove inline style")
            ->setDescription("Inline styles are not allowed int the content")
            ->setTotalSteps($sourcePostCollection->getCount($params))
            ->setOutput($output)
            ->start();

        $it = $sourcePostCollection->find($params);
        while ($it->valid()) {
            $post = $it->current();
            $it->next();

            $re = '/style=".*?"/i';
            $sourceContent = $post->getContent();
            $content = preg_replace($re, "", $sourceContent);

            if ($sourceContent != $content) {
                $post->setContent($content)
                    ->setModifDate();
                $sourcePostCollection->update($post);
            }

            $this->stepComplete();
        }
        $this->done();
        return $unitTracker->next();
    }
}
