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
 * Propiedad package type.
 */
class PackageTypeProperty extends Property implements ChoosablePropertyInterface
{

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPath(): string
    {
        return '[type]';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPrompt(): string
    {
        return 'Package Type';
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'library',
            'project',
            'metapackage',
            'composer-plugin',
        ];
    }
}
