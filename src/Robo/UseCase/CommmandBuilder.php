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

namespace PlanB\Robo\UseCase;

use PlanB\Robo\Services\Context\Context;
use PlanB\Robo\Services\PathManager;

/**
 * Crea objetos Command
 */
class CommmandBuilder
{
    /**
     * @var \PlanB\Robo\Services\PathManager
     */
    private $pathManager;

    /**
     * @var \PlanB\Robo\Services\Context\Context
     */
    private $context;

    /**
     * CommmandBuilder constructor.
     *
     * @param \PlanB\Robo\Services\PathManager $pathManager
     * @param \PlanB\Robo\Services\Context\Context $context
     */
    public function __construct(PathManager $pathManager, Context $context)
    {
        $this->pathManager = $pathManager;
        $this->context = $context;
    }

    /**
     * Crea un objeto CreateFileCommmand
     *
     * @param string $template
     * @param string $filename
     * @param bool $force
     *
     * @return \PlanB\Robo\UseCase\CreateFileCommmand
     */
    public function buildCreateFileCommand(string $template, string $filename, bool $force): CreateFileCommmand
    {
        $template = $this->resolve($template);
        $filename = $this->resolve($filename);

        return new CreateFileCommmand($template, $filename, $force);
    }

    /**
     * Crea un objeto CreateDirectoryCommmand
     *
     * @param string $dirname
     *
     * @return \PlanB\Robo\UseCase\CreateDirectoryCommmand
     */
    public function buildCreateDirectoryCommand(string $dirname): CreateDirectoryCommmand
    {
        $dirname = $this->resolve($dirname);

        return new CreateDirectoryCommmand($dirname);
    }

    /**
     * @param string $value
     *
     * @return string|array<string>|null
     */
    private function resolve(string $value)
    {
        $value = $this->pathManager->resolve($value);

        return $this->context->replace($value);
    }
}
