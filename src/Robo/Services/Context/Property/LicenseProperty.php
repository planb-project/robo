<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Robo\Services\Context\Property;

use PlanB\Robo\Services\Context\ChoosablePropertyInterface;
use PlanB\Robo\Services\Context\Property;

/**
 * Propiedad License
 */
class LicenseProperty extends Property implements ChoosablePropertyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return [
            'MIT',
            'Apache-2.0',
            'Unlicense',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPath(): string
    {
        return '[license]';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPrompt(): string
    {
        return 'License';
    }
}
