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
use League\CLImate\TerminalObject\Dynamic\Input;
use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use PlanB\Robo\Services\Context\ChoosablePropertyInterface;
use PlanB\Robo\Services\Context\Property;

class ConsoleManager
{
    /**
     * @var CLImate
     */
    private $console;

    public function __construct(CLImate $console)
    {
        $this->console = $console;
    }

    public function out(string $text)
    {
        $this->console->output($text);
    }

    public function prompt(Property $property, array $context): string
    {
        $this->showWarning($property);
        $input = $this->buildInput($property, $context);

        return $input->prompt();

    }

    /**
     * @param Property $property
     */
    private function showWarning(Property $property): void
    {
        if (!$property->isValid()) {
            $this->console->cyan($property->getWarningMessage())->white();
        }
    }

    /**
     * @param Property $property
     * @return mixed
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
     * @param Property $property
     * @param array $context
     * @return string
     */
    private function buildPrompt(Property $property, array $context): string
    {
        $default = $property->getDefault($context);
        $question = $property->getPrompt();

        if (!empty($default)) {
            $default = sprintf(' [%s]', $default);
        }

        return sprintf('%s%s:', $question, $default);

    }


}