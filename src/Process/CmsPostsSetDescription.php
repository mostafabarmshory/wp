<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsSetDescription extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, $updateDescription = false)
    {
        $params = new SearchParams();
        $params->perPage = 20;
        $sourcePostCollection = $sourceCms->postCollection();
        $this->setTitle("Update Description")
            ->setDescription("Generate a new description from the content")
            ->setTotalSteps($sourcePostCollection->getCount($params))
            ->setOutput($output)
            ->start();

        $it = $sourcePostCollection->find($params);
        while ($it->valid()) {
            $post = $it->current();
            $it->next();

            // 1- create content
            $oldDescription = $post->getDescription();
            if (empty($oldDescription) || $updateDescription) {
                $description = WordpressUtils::generateDescription($post);
                if ($description != $oldDescription) {
                    $post->setDescription($description)
                        ->setMeta('description', WordpressUtils::generateSeDescription($post))
                        ->setMeta('og:description', WordpressUtils::generateOgDescription($post))
                        ->setModifDate();
                    $sourcePostCollection->update($post);
                }
            }

            $this->stepComplete();
        }
        $this->done();
        return $unitTracker->next();
    }
}

