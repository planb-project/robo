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

use PlanB\Robo\Services\Context\Context;
use PlanB\Robo\Services\ContextManager;
use PlanB\Robo\Services\PathManager;
use PlanB\Robo\UseCase\CommandInterface;
use PlanB\Robo\UseCase\CommmandBuilder;
use Robo\Result;
use Robo\Task\BaseTask;

/**
 * Tarea para crear archivos y directorios
 */
class Boilerplate extends BaseTask
{
    /**
     * @var array<\PlanB\Robo\UseCase\CommandInterface>
     */
    private $commands = [];


    /**
     * @var \PlanB\Robo\UseCase\CommmandBuilder
     */
    private $commmandBuilder;

    /**
     * @var \PlanB\Robo\Services\Context\Context
     */
    private $context;

    /**
     * @var \League\Tactician\CommandBus
     */
    private $commandBus;

    /**
     * Boilerplate constructor.
     *
     * @param \PlanB\Robo\Services\PathManager $pathManager
     * @param \PlanB\Robo\Services\ContextManager $contextManager
     */
    public function __construct(PathManager $pathManager, ContextManager $contextManager)
    {
        $context = $this->getContext($pathManager, $contextManager);

        $this->commmandBuilder = new CommmandBuilder($pathManager, $context);
        $this->commandBus = CommandBus::make($context);
    }

    /**
     * Devuelve el número de pasos
     *
     * @return int|void
     */
    public function progressIndicatorSteps()
    {
        return count($this->commands);
    }

    /**
     * Crea un archivo a partir de una template
     *
     * @param string $template
     * @param string $filename
     * @param bool $force
     *
     * @return \PlanB\Robo\Task\Boilerplate
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function file(string $template, string $filename, bool $force = false): self
    {
        $command = $this->commmandBuilder->buildCreateFileCommand($template, $filename, $force);
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Crea un directorio
     *
     * @param string $dirname
     *
     * @return \PlanB\Robo\Task\Boilerplate
     */
    public function dir(string $dirname): self
    {
        $command = $this->commmandBuilder->buildCreateDirectoryCommand($dirname);
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Ejecuta la tarea
     *
     * @return \Robo\Result
     */
    public function run(): Result
    {
        try {
            $this->tryRun();
        } catch (\Throwable $exception) {
            return Result::fromException($this, $exception);
        }

        return new Result($this, 0, 'all files created', ['time' => $this->getExecutionTime()]);
    }

    /**
     * Ejecuta la tarea, sin capturar las excepciones
     */
    private function tryRun(): void
    {
        $this->startProgressIndicator();

        foreach ($this->commands as $command) {
            $this->execute($command);
        }

        $this->stopProgressIndicator();
    }

    /**
     * Ejecuta un comando
     *
     * @param \PlanB\Robo\UseCase\CommandInterface $command
     */
    private function execute(CommandInterface $command): void
    {
        $result = $this->commandBus->handle($command);

        if ($result) {
            $this->printTaskInfo($command->getSucessMessage());

            return;
        }

        $this->printTaskWarning($command->getFailMessage());
    }

    /**
     * Devuevle el contexto
     *
     * @param \PlanB\Robo\Services\PathManager $pathManager
     * @param \PlanB\Robo\Services\ContextManager $contextManager
     *
     * @return \PlanB\Robo\Services\Context\Context
     */
    private function getContext(PathManager $pathManager, ContextManager $contextManager): Context
    {
        if ($this->context instanceof Context) {
            return $this->context;
        }

        $composerFile = $pathManager->getComposerFile();
        $this->context = $contextManager->parse($composerFile);

        return $this->context;
    }
}
