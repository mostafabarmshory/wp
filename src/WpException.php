<?php
namespace Pluf\WP;

use RuntimeException;

class WpException extends RuntimeException
{

    public array $params = [];

    public function __construct($message, array $params = [], $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->params = $params;
    }
}

