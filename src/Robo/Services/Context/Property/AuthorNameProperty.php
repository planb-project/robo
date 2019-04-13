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

use PlanB\Robo\Services\Context\Property;

/**
 * Propiedad author name.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class AuthorNameProperty extends Property
{
    public function getPath(): string
    {
        return '[authors][0][name]';
    }

    public function getPrompt(): string
    {
        return 'Author Name';
    }


    public function getDefault(array $context): ?string
    {
        return getenv('USER_NAME');
    }
}
