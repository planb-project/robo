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

use Composer\Factory;
use League\CLImate\CLImate;
use League\Tactician\Setup\QuickStart;
use PlanB\Robo\Reader\ConsoleReader;
use PlanB\Robo\Services\ComposerFile;
use PlanB\Robo\Services\Context\Context;
use PlanB\Robo\Services\ContextManager;
use PlanB\Robo\Services\PathManager;
use PlanB\Robo\UseCase\CommandInterface;
use PlanB\Robo\UseCase\CopyDirectoryCommmand;
use PlanB\Robo\UseCase\CopyDirectoryHandler;
use PlanB\Robo\UseCase\CreateDirectoryCommmand;
use PlanB\Robo\UseCase\CreateDirectoryHandler;
use PlanB\Robo\UseCase\CreateFileCommmand;
use PlanB\Robo\UseCase\CommmandBuilder;
use PlanB\Robo\UseCase\CreateFileHandler;
use Robo\Result;
use Robo\Task\BaseTask;
use Symfony\Component\Filesystem\Filesystem;

class Boilerplate extends BaseTask
{
    private $commands = [];

    private $fileSystem;

    /**
     * @var PathManager
     */
    private $pathManager;

    /**
     * @var ContextManager
     */
    private $contextManager;

    /**
     * @var CommmandBuilder
     */
    private $commmandBuilder;

    /**
     * Boilerplate constructor.
     *
     * @param string $pathToProject
     */
    public function __construct(PathManager $pathManager, ContextManager $contextManager)
    {

        $this->fileSystem = new Filesystem();
        $this->pathManager = $pathManager;
        $this->contextManager = $contextManager;
        $context = $this->getContext();

        $this->commmandBuilder = new CommmandBuilder($pathManager, $context);

        $this->commandBus = QuickStart::create([
            CreateFileCommmand::class => new CreateFileHandler($context),
            CreateDirectoryCommmand::class => new CreateDirectoryHandler()
        ]);
    }


    public function progressIndicatorSteps()
    {
        return count($this->commands);
    }

    public function file(string $template, string $filename, bool $force = false): self
    {
        $command = $this->commmandBuilder->buildCreateFileCommand($template, $filename, $force);
        $this->commands[] = $command;
        return $this;
    }

    public function copyDir(string $origin, string $target){
        $command = $this->commmandBuilder->buildCopyDirectoryCommand($origin, $target);
        $this->commands[] = $command;
        return $this;
    }

    public function dir(string $dirname): self
    {
        $command = $this->commmandBuilder->buildCreateDirectoryCommand($dirname);
        $this->commands[] = $command;
        return $this;
    }

    public function run()
    {
        try {
            $this->tryRun();
        } catch (\Exception $exception) {
            return Result::fromException($this, $exception);
        }

        return new Result($this, 0, 'all files created', ['time' => $this->getExecutionTime()]);
    }

    private function tryRun(): void
    {
        $this->startProgressIndicator();
        foreach ($this->commands as $command) {
            $this->execute($command);
        }
        $this->stopProgressIndicator();
    }

    /**
     * @param $fileDump
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
     * @return Context
     */
    private function getContext(): Context
    {
        $pathToComposer = $this->pathManager->resolve('@/composer.json');

        if (!$this->fileSystem->exists($pathToComposer)) {
            $this->fileSystem->dumpFile($pathToComposer, '{}');
        }

        $composerFile = new ComposerFile($pathToComposer);
        return $this->contextManager->parse($composerFile);
    }


}