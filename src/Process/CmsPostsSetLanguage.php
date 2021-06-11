<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsSetLanguage
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, ?string $updateLanguage = null)
    {
        $output->print("Setting language of posts");
        if (empty($updateLanguage)) {
            $output->print("........... [not found]");
        }

        $params = new SearchParams();
        $params->perPage = 20;
        $postCollection = $sourceCms->postCollection();
        $it = $postCollection->find($params);
        $index = 0;
        while ($it->valid()) {
            $index ++;
            $post = $it->current();
            $it->next();
            $output->print(".");

            // 1- create content
            $post->setMeta('language', $updateLanguage);
            $postCollection->update($post);
        }
        $output->println("[ok]");
        return $unitTracker->next();
    }
}

