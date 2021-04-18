<?php
namespace Pluf\WP\Cli;

class OutputStandard extends Output
{

    public function __construct()
    {
        parent::__construct(STDOUT);
    }
}

