<?php
namespace Pluf\WP\Process;

use Pluf\WP\PostInterface;

class WordpressUtils
{

    public static function fetchContent(PostInterface $post)
    {
        $origin = $post->getOrigin();
        return $origin['content']['rendered'];
    }

    public static function fetchTitle(PostInterface $post)
    {
        $origin = $post->getOrigin();
        return $origin['title']['rendered'];
    }

    public static function generateDescription(PostInterface $post): string
    {
        $des = strip_tags($post->getContent());
        return self::clean($des, 255);
    }

    public static function generateSeDescription(PostInterface $post): string
    {
        $des = strip_tags($post->getContent());
        return self::clean($des, 255);
    }

    public static function generateOgDescription(PostInterface $post): string
    {
        $des = strip_tags($post->getContent());
        return self::clean($des, 255);
    }

    public static function clean($str, $len)
    {
        $str = self::minifyHtml($str);
        if (strlen($str) > $len) {
            $str = mb_substr($str, 0, $len);
        }
        return $str;
    }

    public static function minifyHtml(string $Html): string
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

