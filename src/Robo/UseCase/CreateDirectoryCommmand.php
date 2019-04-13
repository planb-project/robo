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

/**
 * Comando para crear directorios
 */
class CreateDirectoryCommmand implements CommandInterface
{
    /**
     * @var string
     */
    private $dirname;

    /**
     * CreateDirectoryCommmand constructor.
     *
     * @param string $dirname
     */
    public function __construct(string $dirname)
    {
        $this->dirname = $dirname;
    }

    /**
     * Devuelve la ruta de destino
     *
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getSucessMessage(): string
    {
        return sprintf("directory '%s' created sucessfully", $this->dirname);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getFailMessage(): string
    {
        return sprintf("directory '%s' not created because already exists", $this->dirname);
    }
}
