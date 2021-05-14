<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsSetDescription
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, $updateDescription = false)
    {
        $output->print("Setting description of posts");

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
            $description = $post->getDescription();
            if (empty($description) || $updateDescription) {
                $post->setDescription($this->generateDescription($post));
                $post->setMeta('description', $this->generateSeDescription($post));
                $post->setMeta('og:description', $this->generateOgDescription($post));
                $postCollection->update($post);
            }
        }
        $output->println(". [ok]");
        return $unitTracker->next();
    }

    public function generateDescription(): string
    {
        return 'TODO';
    }

    public function generateSeDescription(): string
    {
        return 'TODO';
    }

    public function generateOgDescription(): string
    {
        return 'TODO';
    }
}

