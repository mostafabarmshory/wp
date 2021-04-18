<?php
namespace Pluf\WP;

trait AssertTrait
{

    public function assertTrue($value, $message, $param)
    {
        if (! $value) {
            throw new WpException($message, $param, 1, null);
        }
    }

    public function assertIsDir($value, $message, $param)
    {
        if (! is_dir($value)) {
            throw new WpException($message, $param, 1, null);
        }
    }
}

