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

namespace PlanB\Robo\Services\Context;


use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class PropertyValidator
{
    /**
     * @var Validation
     */
    private $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }


    public function validate(?string $value, Property $property): bool
    {

        $constraintList = new ConstraintList();

        if ($property instanceof ValidablePropertyInterface) {
            $property->configConstraintList($constraintList);
        }

        if ($property instanceof ChoosablePropertyInterface) {
            $choice = new Choice();
            $choice->choices = $property->getOptions();
            $choice->message = sprintf('Los valores correctos son: [%s]', implode(' | ', $choice->choices));
            $constraintList->addConstraint($choice);
        }

        $violations = $this->validator->validate($value, $constraintList->toArray());

        if (0 === $violations->count()) {
            return true;
        }

        $message = $this->parseMessage($value, $violations);
        $property->markAsInvalid($message);

        return false;
    }

    /**
     * @param ConstraintViolationList $violations
     * @return string
     */
    private function parseMessage(?string $value, ConstraintViolationList $violations): ?string
    {
        if(empty($value)){
            return null;
        }

        $messages = [];
        foreach ($violations as $violation) {
            $messages[] = $violation->getMessage();
        }

        $errorMessage = implode("\n", $messages);
        return sprintf("El valor '%s' no es correcto: \n%s", $value, $errorMessage);
    }
}