<?php
namespace Pluf\WP\Process;

use Pluf\WP\CmsAbstract;
use Pluf\WP\Local;
use Pluf\WP\Std;
use Pluf\WP\Wordpress;

class CmsLoad
{

    protected function toCms($type, $url, $auth, string $baseDir = '.'): CmsAbstract
    {
        // create local storage id
        $sourceUrl = parse_url($url);
        switch ($sourceUrl['scheme']) {
            case 'http':
            case 'https':
                if ($type == 'wp') {
                    $cms = new Wordpress\Cms($url, $auth);
                } else {
                    $cms = new Std\Cms($url, $auth);
                }
                break;
            case 'local':
                $cms = new Local\Cms($sourceUrl['host'], $baseDir);
                break;
                break;
        }
        // load storate
        $cms->init();
        return $cms;
    }
}

