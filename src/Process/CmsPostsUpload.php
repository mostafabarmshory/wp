<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsPostsUpload
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->print("Getting start to uplad posts");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $postCollection = $distCms->postCollection();
        $index = 0;
        while ($it->valid()) {
            $index ++;
            $post = $it->next();
            // if vebose
            $output->print(".");

            // 1- create content
            $tpost = $postCollection->getByName($post->getName());
            if (! isset($tpost)) {
                $tpost = $postCollection->put($post);
            }
            
            // 2- update info
            if (! isset($tpost) || $post->getModifDate() > $tpost->getModifDate()) {
                $tpost
                    // fill data
                    ->setTitle($post->getTitle($post))
                    ->setMediaType($post->getMediaType())
                    ->setMimeType($post->getMimeType())
                    ->setFileName($post->getFileName())
                    // fill content
                    ->setContent($post->getContent($post));
                // fill meta
                $metas = $post->getMetas();
                foreach ($metas as $key => $value){
                    $tpost->setMeta($key, $value);
                }
                $postCollection->update($tpost);
            }
            
            // TODO: 5- update tags
            // TODO: 6- update categories
        }
        $output->println("[ok]");
        return $unitTracker->next();
    }
}

