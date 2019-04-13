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

namespace PlanB\Robo\Task;

use League\Tactician\Setup\QuickStart;
use PlanB\Robo\Services\Context\Context;
use PlanB\Robo\UseCase\CreateDirectoryCommmand;
use PlanB\Robo\UseCase\CreateDirectoryHandler;
use PlanB\Robo\UseCase\CreateFileCommmand;
use PlanB\Robo\UseCase\CreateFileHandler;

/**
 * Command Bus
 */
class CommandBus
{
    /**
     * Crea una instancia del bus de comandos
     *
     * @param \PlanB\Robo\Services\Context\Context $context
     *
     * @return \League\Tactician\CommandBus
     */
    public static function make(Context $context): \League\Tactician\CommandBus
    {
        return QuickStart::create([
            CreateFileCommmand::class => new CreateFileHandler($context),
            CreateDirectoryCommmand::class => new CreateDirectoryHandler(),
        ]);
    }
}
