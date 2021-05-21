<?php
namespace Pluf\WP\Process;

use Pluf\Scion\UnitTrackerInterface;
use Pluf\WP\CmsAbstract;
use Pluf\WP\SearchParams;
use Pluf\WP\Cli\Output;
use Pluf\WP\PostInterface;

class CmsPostsSetDescription
{

    public function __invoke(UnitTrackerInterface $unitTracker, CmsAbstract $sourceCms, Output $output, $updateDescription = false)
    {
        $output->print("Setting description of posts");

        $params = new SearchParams();
        $params->perPage = 20;
        $postCollection = $sourceCms->postCollection();
        $it = $postCollection->find($params);
        $index = 0;
        while ($it->valid()) {
            $index ++;
            $post = $it->next();
            $output->print(".");

            // 1- create content
            $description = $post->getDescription();
            if (empty($description) || $updateDescription) {
                $post->setDescription($this->generateDescription($post));
                $post->setMeta('description', $this->generateSeDescription($post));
                $post->setMeta('og:description', $this->generateOgDescription($post));
                $postCollection->update($post);
            }
        }
        $output->println("[ok]");
        return $unitTracker->next();
    }

    public function generateDescription(PostInterface $post): string
    {
        $des = strip_tags($post->getContent());
        return $this->clean($des, 255);
    }

    public function generateSeDescription(PostInterface $post): string
    {
        $des = strip_tags($post->getContent());
        return $this->clean($des, 255);
    }

    public function generateOgDescription(PostInterface $post): string
    {
        $des = strip_tags($post->getContent());
        return $this->clean($des, 255);
    }

    private function clean($str, $len)
    {
        $str = $this->minifyHtml($str);
        if (strlen($str) > $len) {
            $str = substr($str, 0, $len);
        }
        return $str;
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

