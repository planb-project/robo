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

/**
 * Propiedad que elije su valor entre una lista de opciones
 */
interface ChoosablePropertyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOptions(): array;
}
