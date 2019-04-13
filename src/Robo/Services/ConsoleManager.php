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

namespace PlanB\Robo\Services;

use League\CLImate\CLImate;
use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use PlanB\Robo\Services\Context\ChoosablePropertyInterface;
use PlanB\Robo\Services\Context\Property;

/**
 * Gestión de la información por consola
 * Es un wrapper de CLIMate
 */
class ConsoleManager
{
    /**
     * @var \League\CLImate\CLImate
     */
    private $console;

    /**
     * ConsoleManager constructor.
     *
     * @param \League\CLImate\CLImate $console
     */
    public function __construct(CLImate $console)
    {
        $this->console = $console;
    }

    /**
     * Muestra un texto por consola
     *
     * @param string $text
     */
    public function out(string $text): void
    {
        $this->console->output($text);
    }

    /**
     * Muestra el prompt de una propiedad
     *
     * @param \PlanB\Robo\Services\Context\Property $property
     * @param array<mixed> $context
     *
     * @return string
     */
    public function prompt(Property $property, array $context): string
    {
        $this->showWarning($property);
        $input = $this->buildInput($property, $context);

        return $input->prompt();
    }

    /**
     * Muestra el texto de advertencia de una propiedad
     *
     * @param \PlanB\Robo\Services\Context\Property $property
     */
    private function showWarning(Property $property): void
    {
        if ($property->isValid()) {
            return;
        }

        $this->console->cyan($property->getWarningMessage())->white();
    }

    /**
     * Crea el objeto Input relacionado con una propiedad
     *
     * @param \PlanB\Robo\Services\Context\Property $property
     * @param array<mixed> $context
     *
     * @return \League\CLImate\TerminalObject\Dynamic\InputAbstract
     */
    private function buildInput(Property $property, array $context): InputAbstract
    {
        $prompt = $this->buildPrompt($property, $context);

        $default = $property->getDefault($context);
        $input = $this->console->input($prompt);
        $input->defaultTo($default);

        if ($property instanceof ChoosablePropertyInterface) {
            $options = $property->getOptions();
            $input = $this->console->radio($prompt, $options);
        }

        return $input;
    }

    /**
     * Formatea el texto de prompt de una propiedad
     *
     * @param \PlanB\Robo\Services\Context\Property $property
     * @param array<mixed> $context
     *
     * @return string
     */
    private function buildPrompt(Property $property, array $context): string
    {
        $default = $property->getDefault($context);
        $question = $property->getPrompt();

        if (!is_null($default)) {
            $default = sprintf(' [%s]', $default);
        }

        return sprintf('%s%s:', $question, $default);
    }
}
