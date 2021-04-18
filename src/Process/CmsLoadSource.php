<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;

class CmsLoadSource extends CmsLoad
{

    public function __invoke(UnitTrackerInterface $unitTracker, string $source, string $sourceType, string $baseDir = '.')
    {
        // load storate
        return $unitTracker->next([
            'sourceCms' => $this->toCms($sourceType, $source, null, $baseDir)
        ]);
    }
}

