<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;
use Pluf\WP\PostInterface;
use Pluf\WP\PostCollectionInterface;

class CmsPostsUpload extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output)
    {
        $params = new SearchParams();
        $params->perPage = 20;
        $srcPostCollection = $sourceCms->postCollection();

        $this->setTitle("Upload Posts")
            ->setDescription("Upload and update remote posts")
            ->setTotalSteps($srcPostCollection->getCount($params))
            ->setOutput($output)
            ->start();

        $it = $srcPostCollection->find($params);
        $postCollection = $distCms->postCollection();
        while ($it->valid()) {
            $post = $it->current();

            // If the post is not changed from the latest upload it is ignored
            if ($this->isPostChanged($post)) {

                // create content
                $tpost = $postCollection->getByName($post->getName());
                if (! isset($tpost)) {
                    $tpost = $postCollection->put($post);
                }

                // 2- update info
                if (! isset($tpost) || $post->getModifDate() > $tpost->getModifDate()) {
                    $tpost->setTitle($post->getTitle())
                        ->setMediaType($post->getMediaType())
                        ->setMimeType($post->getMimeType())
                        ->setFileName($post->getFileName())
                        ->setContent($post->getContent());
                    // fill meta
                    $metas = $post->getMetas();
                    foreach ($metas as $key => $value) {
                        $tpost->setMeta($key, $value);
                    }
                    $postCollection->update($tpost);
                    $postCollection->performTransaction($tpost, 'touch', []);
                }

                // TODO: 5- update tags
                // TODO: 6- update categories

                $this->markPostIsClean($srcPostCollection, $post);
            }
            
            // next loop
            $it->next();
            $this->stepComplete();
        }
        $this->done();

        return $unitTracker->next();
    }

    /**
     * Checks if the post is changed from the lat time update
     *
     * @param PostInterface $post
     * @return bool
     */
    public function isPostChanged(PostInterface $post): bool
    {
        $uploadTime = $post->getUploadDate();
        return empty($uploadTime) || $post->getModifDate() > $uploadTime;
    }

    /**
     * Sets upload date and save the post
     *
     * @param PostCollectionInterface $postCollection
     * @param PostInterface $post
     */
    public function markPostIsClean(PostCollectionInterface $postCollection, PostInterface $post)
    {
        $post->setUploadDate();
        $postCollection->update($post);
    }
}

