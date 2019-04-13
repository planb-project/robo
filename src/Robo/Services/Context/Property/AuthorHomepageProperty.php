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

use PlanB\Robo\Services\Context\ConstraintList;
use PlanB\Robo\Services\Context\Property;
use PlanB\Robo\Services\Context\ValidablePropertyInterface;
use Symfony\Component\Validator\Constraints\Url;

/**
 * Propiedad Author Homepage.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class AuthorHomepageProperty extends Property implements ValidablePropertyInterface
{

    public function getPath(): string
    {
        return '[authors][0][homepage]';
    }

    public function getPrompt(): string
    {
        return 'Author website';
    }

    /**
     * @return array<Constraint>
     */
    public function configConstraintList(ConstraintList $constraintList): void
    {
        $constraintList->addConstraint(new Url());
    }

    public function getDefault(array $context): ?string
    {
        return sprintf('https://github.com/%s/', $context['github_organization']);
    }
}
