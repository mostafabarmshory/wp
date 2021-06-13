<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;

/**
 * Pars and check all params
 *
 * @author maso
 *        
 */
class CmsPostsContentMinifyHtml extends ProcessWithProgress
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output)
    {
        $params = new SearchParams();
        $params->perPage = 20;
        $sourcePostCollection = $sourceCms->postCollection();
        $this->setTitle("Minifiying HTML")
            ->setDescription("To remove extra space and compress HTML")
            ->setTotalSteps($sourcePostCollection->getCount($params))
            ->setOutput($output)
            ->start();
            

        $it = $sourcePostCollection->find($params);
        while ($it->valid()) {
            $post = $it->current();
            $it->next();

            $sourceContent = $post->getContent();
            $content = $this->minifyHtml($sourceContent);
            
            if($content != $sourceContent) {
                $post->setContent($content)
                    ->setModifDate();
                $sourcePostCollection->update($post);
            }
            
            $this->stepComplete();
        }
        $this->done();
        return $unitTracker->next();
    }

    function minifyHtml($Html)
    {
        $Search = array(
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/', # Delete multispace (Without \n)
            '/\>\s+\</', # strip whitespaces between tags
            '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
            '/=\s+(\"|\')/'
        ); # strip whitespaces between = "'

        $Replace = array(
            "\n",
            "\n",
            " ",
            "",
            " ",
            "><",
            "$1>",
            "=$1"
        );

        $Html = preg_replace($Search, $Replace, $Html);
        return $Html;
    }
}

