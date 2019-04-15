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
 * Propiedad GithubUsername.
 */
class GithubOrganizationProperty extends Property
{

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPath(): string
    {
        return '[extra][github_organization]';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPrompt(): string
    {
        return 'Github Organization';
    }

    /**
     *  {@inheritdoc}
     *
     * @param array $context
     *
     * @return string|null
     */
    public function getDefault(array $context): ?string
    {
        return getenv('GITHUB_ORGANIZATION');
    }
}
