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

class PathException extends \RuntimeException
{
    public function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, 100, $previous);
    }

    public static function fromPath(string $path, array $available, \Throwable $previous = null)
    {
        $availableAsString = implode(' | ', $available);
        $message = sprintf("'%s' prefix path is invalid, one of [%s] expected", $path, $availableAsString);

        return new self($message, $previous);
    }

}