<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsSetTemplate
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, ?string $updateTemplate = null)
    {
        $output->print("Setting template of posts");
        if (empty($updateTemplate)) {
            $output->print("........... [not found]");
            return $unitTracker->next();
        }

        $params = new SearchParams();
        $params->perPage = 20;
        $postCollection = $sourceCms->postCollection();
        $it = $postCollection->find($params);
        $index = 0;
        while ($it->valid()) {
            $index ++;
            $post = $it->next();
            $output->print(".");

            // 1- create content
            $post->setMeta('template', $updateTemplate);
            $postCollection->update($post);
        }
        $output->println("[ok]");
        return $unitTracker->next();
    }
}

