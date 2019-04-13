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

class CommmandBuilder
{
    /**
     * @var PathManager
     */
    private $pathManager;
    /**
     * @var Context
     */
    private $context;

    public function __construct(PathManager $pathManager, Context $context)
    {
        $this->pathManager = $pathManager;
        $this->context = $context;
    }

    public function buildCreateFileCommand(string $template, string $filename, bool $force)
    {
        $template = $this->resolve($template);
        $filename = $this->resolve($filename);

        return new CreateFileCommmand($template, $filename, $force);
    }

    public function buildCreateDirectoryCommand(string $dirname)
    {
        $dirname = $this->resolve($dirname);
        return new CreateDirectoryCommmand($dirname);
    }

    /**
     * @param string $value
     * @return null|string|string[]
     */
    private function resolve(string $value)
    {
        $value = $this->pathManager->resolve($value);
        return $this->context->replace($value);
    }
}