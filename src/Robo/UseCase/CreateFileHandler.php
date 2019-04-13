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

use PlanB\Robo\Reader\ConsoleReader;
use PlanB\Robo\Services\Context\Context;
use Symfony\Component\Filesystem\Filesystem;

class CreateFileHandler
{

    /**
     * @var array
     */
    private $context;

    private $filesystem;

    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->filesystem = new Filesystem();

    }

    public function handle(CreateFileCommmand $command): bool
    {
        $template = $command->getTemplate();
        $filename = $command->getFilename();

        if ($this->filesystem->exists($filename) AND !$command->isForce()) {
            return false;
        }

        $content = file_get_contents($template);
        $content = $this->context->replace($content);

        $this->filesystem->dumpFile($filename, $content);
        return true;
    }

}
