<?php
namespace Pluf\WP\Process;

use Pluf\WP\Cli\Color;
use Pluf\WP\Cli\Output;
use Pluf\Scion\UnitTrackerInterface;

/**
 * Print out welcome note
 *
 * @author maso
 *        
 */
class Wellcome
{

    public function __invoke(Output $output, UnitTrackerInterface $unitTracker)
    {
        $output->println('

    ____  __      ____   _       ______ 
   / __ \/ /_  __/ __/  | |     / / __ \
  / /_/ / / / / / /_    | | /| / / /_/ /
 / ____/ / /_/ / __/    | |/ |/ / ____/ 
/_/   /_/\__,_/_/       |__/|__/_/      
                                        
                                       ')
            ->println('Wordpress toolkit')
            ->println('Version: ' . Color::blue('0.1'));

        return $unitTracker->next();
    }
}

