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

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, CmsAbstract $distCms, Output $output, ?string $lastUploadDtime = null)
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
            $it->next();
            $this->stepComplete();

            if (! empty($lastUploadDtime) && ! empty($post->getUploadDate()) && $post->getUploadDate() > $lastUploadDtime) {
                continue;
            }

            $tpost = $postCollection->getByName($post->getName());
            // Create if the target post not exist
            if (empty($tpost)) {
                // Create the post
                $tpost = $postCollection->newPost($post->getId());
                $this->fillFrom($tpost, $post);
                $postCollection->put($tpost);
                $postCollection->performTransaction($tpost, 'touch', []);
                continue;
            }

            if ($this->isSourceNewer($post, $tpost)) {
                // update
                $this->fillFrom($tpost, $post);
                $postCollection->update($tpost);
                $postCollection->performTransaction($tpost, 'touch', []);
                $this->markPostIsClean($srcPostCollection, $post);
            } else if ($this->isTargetNewer($post, $tpost)) {
                // sync with remote
                $this->fillFrom($post, $tpost);
                $srcPostCollection->update($post);
                $this->markPostIsClean($srcPostCollection, $post);
            }

        }
        $this->done();

        return $unitTracker->next();
    }

    public function fillFrom(PostInterface $target, PostInterface $source)
    {
        $target->setTitle($source->getTitle())
            ->setDescription($source->getDescription())
            ->setMediaType($source->getMediaType())
            ->setMimeType($source->getMimeType())
            ->setFileName($source->getFileName())
            ->setContent($source->getContent())
            ->setName($source->getName());
        $metas = $source->getMetas();
        foreach ($metas as $key => $value) {
            $target->setMeta($key, $value);
        }
    }

    // /**
    // * Checks if the post is changed from the lat time update
    // *
    // * @param PostInterface $post
    // * @return bool
    // */
    // private function isPostChanged(PostInterface $post): bool
    // {
    // $uploadTime = $post->getUploadDate();
    // return empty($uploadTime) || $post->getModifDate() > $uploadTime;
    // }

    /**
     * Sets upload date and save the post
     *
     * @param PostCollectionInterface $postCollection
     * @param PostInterface $post
     */
    private function markPostIsClean(PostCollectionInterface $postCollection, PostInterface $post)
    {
        $post->setUploadDate();
        $postCollection->update($post);
    }

    private function isSourceNewer(PostInterface $source, PostInterface $target): bool
    {
        $sourceModifTime = $source->getModifDate();
        $targetModifiTIme = $target->getModifDate();

        return $sourceModifTime > $targetModifiTIme;
    }

    private function isTargetNewer(PostInterface $source, PostInterface $target): bool
    {
        $sourceModifTime = $source->getModifDate();
        $targetModifiTIme = $target->getModifDate();
        $uploadTime = $source->getUploadDate();

        return $sourceModifTime < $targetModifiTIme && (empty($uploadTime) || $uploadTime < $targetModifiTIme);
    }
}

