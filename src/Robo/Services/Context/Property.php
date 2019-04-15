<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Robo\Services\Context;

/**
 * Clase base para propiedades de composer.json.
 */
abstract class Property
{
    /**
     * @var string
     */
    private $warningMessage = '';
    /**
     * @var bool
     */
    private $valid = true;


    /** Crea una nueva instancia de esta propiedad
     *
     * @return static
     */
    public static function make()
    {
        return new static();
    }

    /**
     * Devuelve el path de la propiedad en el archivo composer.json
     *
     * @return string
     */
    abstract public function getPath(): string;

    /**
     * Devuelve el prompt de la propiedad
     *
     * @return string
     */
    abstract public function getPrompt(): string;

    /**
     * Agrega un mensaje de advertencia al prompt
     *
     * @param string|null $message
     *
     * @return \PlanB\Robo\Services\Context\Property
     */
    public function markAsInvalid(?string $message): self
    {
        $this->valid = false;
        $this->warningMessage = $message;

        return $this;
    }

    /**
     * Indica si el valor de la propiedad es valido
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * Devuelve el valor por defecto
     *
     * @param array<mixed> $context
     *
     * @return string|null
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getDefault(array $context): ?string
    {
        return null;
    }

    /**
     * Devuelve el mensaje de advertencia
     *
     * @return string|null
     */
    public function getWarningMessage(): ?string
    {
        return $this->warningMessage;
    }

    /**
     * Normaliza un valor
     *
     * @param string $value
     *
     * @return string|null
     */
    public function normalize(string $value): ?string
    {
        return $value;
    }
}
