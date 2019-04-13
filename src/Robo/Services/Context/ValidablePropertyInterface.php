<?php declare(strict_types=1);

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
 * Representa a las propiedades que tienen una validación específica.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
interface ValidablePropertyInterface
{

    /**
     * @return array<Constraint>
     */
    public function configConstraintList(ConstraintList $constraintList): void ;
}
