<?php

namespace PlanB\QA\Tools\Analyzer;

use Edge\QA\Tools\Analyzer\Phpcs;

$autload = realpath(__DIR__.'/../../../../vendor/autoload.php');
include $autload;

class Phpcbf extends Phpcs
{
    public static $SETTINGS = array(
        'optionSeparator' => '=',
        'xml' => [],
        'errorsXPath' => [
            false => null,
            true => null,
        ],
        'composer' => 'squizlabs/php_codesniffer',
    );

    public function __invoke()
    {
        require_once COMPOSER_VENDOR_DIR . '/squizlabs/php_codesniffer/autoload.php';
        return $this->buildPhpcs(\PHP_CodeSniffer\Util\Standards::getInstalledStandards());
    }
}