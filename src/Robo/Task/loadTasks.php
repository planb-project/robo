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


use League\CLImate\CLImate;
use PlanB\Robo\Services\ConsoleManager;
use PlanB\Robo\Services\ContextManager;
use PlanB\Robo\Services\PathManager;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Question\Question;

trait loadTasks
{
    protected function taskBoilerplate()
    {
        $pathManager = new PathManager('.');

        $console = new ConsoleManager(new CLImate());
        $contextManager = new ContextManager($console);

        return $this->task(Boilerplate::class, $pathManager, $contextManager);
    }

}