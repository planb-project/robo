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
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Propiedad package name.
 */
class PackageNameProperty extends Property implements ValidablePropertyInterface
{

    public const PATTERN = '#([A-Za-z0-9][A-Za-z0-9_.-]*)/([A-Za-z0-9][A-Za-z0-9_.-]*)#';

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPath(): string
    {
        return '[name]';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPrompt(): string
    {
        return 'Package Name';
    }

    /**
     * {@inheritdoc}
     *
     * @param \PlanB\Robo\Services\Context\ConstraintList $constraintList
     */
    public function configConstraintList(ConstraintList $constraintList): void
    {
        $regex = new Regex(self::PATTERN);
        $regex->message = "Se esperaba el formato <vendor>/<package>";
        $constraintList->addConstraint($regex);
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $context
     *
     * @return string|null
     */
    public function getDefault(array $context): ?string
    {
        $vendor =  getenv('VENDOR');

        $vendor =  strtolower($vendor);

        if (is_null($vendor)) {
            return null;
        }

        return sprintf('%s/%s', $vendor, $context['github_repository_name']);
    }
}
