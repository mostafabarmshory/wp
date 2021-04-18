<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;

class CmsLoadDist extends CmsLoad
{

    public function __invoke(UnitTrackerInterface $unitTracker,string $distType, string $dist, $distAuth, string $baseDir = '.')
    {
        // load storate
        return $unitTracker->next([
            'distCms' => $this->toCms($distType, $dist, $distAuth, $baseDir)
        ]);
    }
}

