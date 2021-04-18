<?php
namespace Pluf\WP\Cli;

class Output
{
    
    /**
     * Flag to remove color codes from the output
     *
     * @var bool
     */
    public $noColor = false;
    
    /**
     * Force render color code
     *
     * @var bool
     */
    public $forceColor = false;
    public $stream;

    public function __construct($outputStream = STDOUT)
    {
        $this->stream = $outputStream;
    }

    public function println($value): self
    {
        return $this->print($value)->print(PHP_EOL);
    }

    public function print($messages): self
    {
        
        $str = is_array($messages) ? implode("\n", $messages) : (string)$messages;
        
        fwrite($this->stream, $str);
        return $this;
    }
}

