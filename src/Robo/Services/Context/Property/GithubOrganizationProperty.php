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

use PlanB\Robo\Services\Context\NotStorablePropertyInterface;
use PlanB\Robo\Services\Context\Property;

/**
 * Propiedad GithubUsername.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class GithubOrganizationProperty extends Property
{

    public function getPath(): string
    {
        return '[extra][github_organization]';

    }

    public function getPrompt(): string
    {
        return 'Github Organization';
    }

    public function getDefault(array $context): ?string
    {
        return getenv('GITHUB_ORGANIZATION');
    }
}
