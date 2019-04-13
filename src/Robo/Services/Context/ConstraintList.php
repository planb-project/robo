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


use JakubOnderka\PhpParallelLint\ArrayIterator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Traversable;

class ConstraintList
{
    private $constraints = [];

    public function __construct()
    {
        $notBlank = new NotBlank();
        $notBlank->message = 'El valor es requerido';

        $this->constraints[] = $notBlank;
    }

    public function addConstraint(Constraint $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * @return array<Constraint>
     */
    public function toArray()
    {
        return $this->constraints;
    }
}