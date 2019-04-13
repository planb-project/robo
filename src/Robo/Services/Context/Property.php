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

use PlanB\Wand\Core\Context\Exception\InvalidAnswerException;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Throwable;

/**
 * Clase base para propiedades de composer.json.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
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


    abstract public function getPath(): string;

    abstract public function getPrompt(): string;

    public function markAsInvalid(?string $message): self
    {
        $this->valid = false;
        $this->warningMessage = $message;
        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getDefault(array $context): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getWarningMessage(): ?string
    {
        return $this->warningMessage;
    }

    public function normalize(string $value): ?string
    {
        return $value;
    }


}
