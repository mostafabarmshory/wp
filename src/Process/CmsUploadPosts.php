<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

class CmsUploadPosts
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $output->println("Getting start to uplad posts");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $postCollection = $distCms->postCollection();
        $index = 0;
        while ($it->valid()) {
            $index ++;
            $post = $it->next();
            // if vebose
            $output->println("[$index]" . $post->getName());

            // 1- create content
            $tpost = $postCollection->getByName($post->getName());
            if (! isset($tpost)) {
                $output->println("Content not found. New content created:" . $post->getName());
                $tpost = $postCollection->put($post);
            } else {
                $output->println("Simular content found :" . $post->getName());
            }
            
            if (isset($tpost) && $post->getModifDate() > $tpost->getModifDate()) {
                
            }
            // 2- update info
            if (! isset($tpost) || $post->getModifDate() > $tpost->getModifDate()) {
                $output->println("Try to update the content :" . $post->getName());
                $tpost->setContent($post->getContent($post))
                    ->setTitle($post->getTitle($post))
                    ->setMediaType($post->getMediaType())
                    ->setMimeType($post->getMimeType())
                    ->setFileName($post->getFileName());
                $postCollection->update($tpost);
            }
            
            // 3- update content
            // TODO: 4- update meatdata
            // TODO: 5- update tags
            // TODO: 6- update categories
            // TODO: 7- 
        }
        $output->println("Finish the clone posts");
        return $unitTracker->next();
    }
}

