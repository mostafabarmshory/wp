<?php
namespace Pluf\WP;

class Utils
{

    public static function postToForm(PostInterface $post): array
    {
        return [
            'name' => $post->getName(),
            'title' => $post->getTitle(),
            'description' => $post->getDescription(),
            'file_name' => $post->getFIleName(),
            'media_type' => $post->getMediaType(),
            'mime_type' => $post->getMimeType()
        ];
    }
}

