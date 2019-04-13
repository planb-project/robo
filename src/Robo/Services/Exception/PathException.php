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

namespace PlanB\Robo\Services\Exception;

use Throwable;

/**
 * Exception para rutas
 */
class PathException extends \RuntimeException
{
    /**
     * PathException constructor.
     *
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 100, $previous);
    }

    /**
     * El prefijo no es correcto
     *
     * @param string $prefix
     * @param array<string> $available
     * @param \Throwable|null $previous
     *
     * @return \PlanB\Robo\Services\Exception\PathException
     */
    public static function invalidPrefix(string $prefix, array $available, ?\Throwable $previous = null): PathException
    {
        $availableAsString = implode(' | ', $available);
        $message = sprintf("'%s' prefix path is invalid, one of [%s] expected", $prefix, $availableAsString);

        return new self($message, $previous);
    }
}
