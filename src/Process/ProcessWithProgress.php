<?php
namespace Pluf\WP\Process;

/**
 * Abstract process with CMD progress bar
 *
 * TODO: add cmd progress bar
 *
 * @author maso
 *        
 */
class ProcessWithProgress
{

    private ?string $title;

    private ?string $description;

    private int $totalSteps = - 1;

    private int $completedSteps = 0;

    private $output = null;

    public function setOutput($output): self
    {
        $this->output = $output;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setTotalSteps(int $totalSteps): self
    {
        $this->totalSteps = $totalSteps;
        return $this;
    }

    public function start(): self
    {
        $this->output->print($this->title . ':');
        $this->completedSteps = 0;
        return $this;
    }

    public function done(): self
    {
        $this->output->println('[ok]');
        return $this;
    }

    public function stepComplete(int $count = 1): self
    {
        $this->completedSteps += $count;
        $this->output->print('.');
        return $this;
    }
}

