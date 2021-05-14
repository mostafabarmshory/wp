<?php
namespace Pluf\WP\Process;

use Pluf\WP\Cli\Output;
use Pluf\Scion\UnitTrackerInterface;

/**
 * Pars and check all params
 *
 * @author maso
 *        
 */
class GetoptUpdateParams
{

    public function __invoke(UnitTrackerInterface $unitTracker, Output $output)
    {

        // Script example.php
        $shortopts = "";
        $shortopts .= "s:"; // Required value
        $shortopts .= "v::"; // Optional value
        $shortopts .= "V";
        $shortopts .= "s:";
        $shortopts .= "d:";

        $longopts = array(
            "source:", // Required value
            "source-type:", // Required value
            "source-login:", // No value
            "source-password:",
            "dist:", // Optional value
            "dist-type:", // Optional value
            "login:", // No value
            "password:",
            // Options
            "verbose",
            'base-dir:',

            // setting propery
            'key:',
            'value:',

            "canonical-link-prefix:",
            "update-description"
        );
        $result = getopt($shortopts, $longopts);

        $options = [
            'updateDescription' => $this->getOptionBool($result, [
                'update-description',
            ], false),
            'canonicalLinkPrefix' => $this->getOption($result, [
                'canonical-link-prefix'
            ], ''),
            'baseDir' => $this->getOption($result, [
                'base-dir'
            ], '.'),
            'verbose' => $this->getOptionBool($result, [
                'verbose',
                'V'
            ], false),
            'source' => $this->getOption($result, [
                'source',
                's'
            ]),
            'sourceType' => $this->getOption($result, [
                'source-type'
            ], 'wp'),
            'sourceAuth' => $this->getAuth($result, 'source-'),
            'dist' => $this->getOption($result, [
                'dist',
                'd'
            ]),
            'distType' => $this->getOption($result, [
                'dist-type'
            ], 'std'),
            'distAuth' => $this->getAuth($result, 'dist-'),

            'propertyKey' => $this->getOption($result, [
                'key'
            ], null),
            'propertyValue' => $this->getOption($result, [
                'value'
            ], null)
        ];
        $this->printOptions($output, $options);
        return $unitTracker->next($options);
    }

    /**
     * Print all options into the standard output
     *
     * @param Output $output
     * @param array $options
     */
    private function printOptions(Output $output, array $options)
    {
        $output->println('-----------------------------------------------------')
            ->println('Options')
            ->println('- Verbose         : ' . $options['verbose'])
            ->println('- Base Dir        : ' . $options['baseDir'])
            ->println('Resources')
            ->println('- Source          : ' . $options['source'])
            ->println('- Source Type     : ' . $options['sourceType'])
            ->println('- Source Auth     : ' . $this->authToStr($options['sourceAuth']))
            ->println('- Dist            : ' . $options['dist'])
            ->println('- Dist Type       : ' . $options['distType'])
            ->println('- Dist Auth       : ' . $this->authToStr($options['distAuth']))
            ->println('------------------------------------------------------');
    }

    /**
     * Gets boolean options
     *
     * @param array $params
     * @param array $keys
     * @param bool $default
     * @return bool
     */
    private function getOptionBool(array $params, array $keys, bool $default): bool
    {
        $result = $default;
        foreach ($keys as $key) {
            if (array_key_exists($key, $params)) {
                $result = true;
                return $result;
            }
        }
        return $result;
    }

    /**
     * Gets string options
     *
     * @param array $params
     * @param array $keys
     * @param bool $default
     * @return bool
     */
    private function getOption(array $params, array $keys, string $default = null): ?string
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $params)) {
                return $params[$key];
            }
        }
        return $default;
    }

    /**
     * Get authentication options
     *
     * @param array $params
     * @return string[]
     */
    private function getAuth(array $params, string $prefix = '')
    {
        return [
            'login' => $this->getOption($params, [
                $prefix . 'login',
                $prefix . 'user'
            ]),
            'pass' => $this->getOption($params, [
                $prefix . 'pass'
            ]),
            'token' => $this->getOption($params, [
                $prefix . 'token'
            ])
        ];
    }

    /**
     * convert authentication to string
     *
     * @param array $options
     * @return string
     */
    private function authToStr(array $auth): string
    {
        $output = '';
        if (isset($auth['token'])) {
            $output .= 'token: ******';
        } else {
            $output .= 'login: ' . $auth['login'];
            $output .= ' pass: *****';
        }
        return $output;
    }
}

