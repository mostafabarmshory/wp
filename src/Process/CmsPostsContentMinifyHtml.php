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
class CmsPostsContentMinifyHtml
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output)
    {
        $output->print("Minifiying HTML");

        $params = new SearchParams();
        $params->perPage = 20;
        $it = $sourceCms->postCollection()->find($params);
        $index = 0;
        while ($it->valid()) {
            $post = $it->next();

            $post->setContent($this->minifyHtml($post->getContent()));
            $sourceCms->postCollection()->update($post);

            $index ++;
            // if vebose
            $output->print(".");
        }
        $output->println(".");
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

