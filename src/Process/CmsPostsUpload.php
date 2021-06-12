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
            $tpost = $postCollection->getByName($post->getName());

            if (empty($tpost)) {
                // Create the post
                $tpost = $postCollection->newPost($post->getId());
                $this->fillFrom($tpost, $post);
                $postCollection->put($tpost);
                $postCollection->performTransaction($tpost, 'touch', []);
            } else if ($this->isPostChanged($post) || $this->isSourceNewer($post, $tpost)) {
                // update
                $this->fillFrom($tpost, $post);
                $postCollection->update($tpost);
                $postCollection->performTransaction($tpost, 'touch', []);
            } else if ($this->isTargetNewer($post, $tpost)) {
                // sync with remote
                $this->fillFrom($post, $tpost);
                $srcPostCollection->update($post);
            }
            $this->markPostIsClean($srcPostCollection, $post);

            // next loop
            $it->next();
            $this->stepComplete();
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
    
    public function isSourceNewer(PostInterface $source, PostInterface $target): bool
    {
        $sourceModifTime = $source->getModifDate();
        $targetModifiTIme = $target->getModifDate();
        
        return $sourceModifTime > $targetModifiTIme;
    }
    
    public function isTargetNewer(PostInterface $source, PostInterface $target): bool
    {
        $sourceModifTime = $source->getModifDate();
        $targetModifiTIme = $target->getModifDate();
        
        return $sourceModifTime < $targetModifiTIme;
    }
}

