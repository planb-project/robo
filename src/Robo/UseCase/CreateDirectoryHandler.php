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

class CreateDirectoryHandler
{

    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    public function handle(CreateDirectoryCommmand $command): bool
    {
        $dirname = $command->getDirname();

        if($this->filesystem->exists($dirname)){
            return false;
        }

        $this->filesystem->mkdir($dirname);
        $this->filesystem->touch("$dirname/.gitkeep");
        return true;
    }

}