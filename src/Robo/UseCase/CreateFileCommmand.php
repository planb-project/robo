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

use Webmozart\Assert\Assert;

/**
 * Commando para crear archivos
 */
class CreateFileCommmand implements CommandInterface
{

    /**
     * @var string
     */
    private $template;
    /**
     * @var string
     */
    private $filename;

    /**
     * @var bool
     */
    private $force;

    /**
     * CreateFileCommmand constructor.
     *
     * @param string $template
     * @param string $filename
     * @param bool $force
     */
    public function __construct(string $template, string $filename, bool $force)
    {
        Assert::fileExists($template);

        $this->template = $template;
        $this->filename = $filename;
        $this->force = $force;
    }

    /**
     * Devuelve la template
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Devuelve la ruta destino
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Indica si se va a sobreescribir el destino si ya existe
     *
     * @return bool
     */
    public function isForce(): bool
    {
        return $this->force;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getSucessMessage(): string
    {
        return sprintf("file '%s' created sucessfully", $this->filename);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getFailMessage(): string
    {
        return sprintf("file '%s' not created because already exists", $this->filename);
    }
}
