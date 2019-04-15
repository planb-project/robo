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

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Colección de constraints para una propiedad
 */
class ConstraintList
{
    /**
     * @var array<\Symfony\Component\Validator\Constraint>
     */
    private $constraints = [];

    /**
     * ConstraintList constructor.
     */
    public function __construct()
    {
        $notBlank = new NotBlank();
        $notBlank->message = 'El valor es requerido';

        $this->constraints[] = $notBlank;
    }

    /**
     * Agrega una constraint
     *
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function addConstraint(Constraint $constraint): void
    {
        $this->constraints[] = $constraint;
    }

    /**
     * @return array<\Symfony\Component\Validator\Constraint>
     */
    public function toArray(): array
    {
        return $this->constraints;
    }
}
