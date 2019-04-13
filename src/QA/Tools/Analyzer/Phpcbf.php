<?php
/**
 * This file is part of the planb project.
 *
 * (c) jmpantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PlanB\QA\Tools\Analyzer;

use Edge\QA\Tools\Analyzer\Phpcs;

/**
 * Ejecuta phpcbf
 */
class Phpcbf extends Phpcs
{
    /**
     * @var array<mixed>
     */
    public static $SETTINGS = array(
        'optionSeparator' => '=',
        'xml' => [],
        'errorsXPath' => [
            false => null,
            true => null,
        ],
        'composer' => 'squizlabs/php_codesniffer',
    );

    /**
     * Ejecuta el comando
     *
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        require_once COMPOSER_VENDOR_DIR.'/squizlabs/php_codesniffer/autoload.php';

        return $this->buildPhpcs(\PHP_CodeSniffer\Util\Standards::getInstalledStandards());
    }
}
