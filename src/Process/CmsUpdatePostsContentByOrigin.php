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
class CmsUpdatePostsContentByOrigin
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output)
    {
        $output->println("Getting start to update posts");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $index = 0;
        while ($it->valid()) {
            $post = $it->next();
            $post->setContent($this->fetchContent($post))
                ->setTitle($this->fetchTitle($post))
                ->setMeta('title', $this->fetchTitle($post))
                ->setMediaType('post')
                ->setMimeType('text/html')
                ->setFileName($post->getId() . '.html');
            $sourceCms->postCollection()->update($post);

            $index ++;
            // if vebose
            $output->println("[$index]" . $post->getId() . " Is updated");
        }
        $output->println("Finish the update posts");
        return $unitTracker->next();
    }

    public function fetchContent(PostInterface $post)
    {
        $origin = $post->getOrigin();
        return $origin['content']['rendered'];
    }

    public function fetchTitle(PostInterface $post)
    {
        $origin = $post->getOrigin();
        return $origin['title']['rendered'];
    }
}