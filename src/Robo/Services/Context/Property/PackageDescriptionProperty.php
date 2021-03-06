<?php declare(strict_types=1);

/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Robo\Services\Context\Property;

use PlanB\Robo\Services\Context\Property;

/**
 * Propiedad package description.
 */
class PackageDescriptionProperty extends Property
{

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPath(): string
    {
        return '[description]';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPrompt(): string
    {
        return 'Package Description';
    }
}
