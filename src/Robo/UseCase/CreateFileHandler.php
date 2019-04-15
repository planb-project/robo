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
use Symfony\Component\Filesystem\Filesystem;

/**
 * Manejador para crear archivos
 */
class CreateFileHandler
{

    /**
     * @var \PlanB\Robo\Services\Context\Context
     */
    private $context;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * CreateFileHandler constructor.
     *
     * @param \PlanB\Robo\Services\Context\Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->filesystem = new Filesystem();
    }

    /**
     * Ejecuta el comando
     *
     * @param \PlanB\Robo\UseCase\CreateFileCommmand $command
     *
     * @return bool
     */
    public function handle(CreateFileCommmand $command): bool
    {
        $template = $command->getTemplate();
        $filename = $command->getFilename();

        if ($this->filesystem->exists($filename) and !$command->isForce()) {
            return false;
        }

        $content = file_get_contents($template);
        $content = $this->context->replace($content);

        $this->filesystem->dumpFile($filename, $content);

        return true;
    }
}
