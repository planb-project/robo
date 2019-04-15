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
use Symfony\Component\Validator\Constraints\Email;

/**
 * Propiedad author email.
 */
class AuthorEmailProperty extends Property implements ValidablePropertyInterface
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPath(): string
    {
        return '[authors][0][email]';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getPrompt(): string
    {
        return 'Author Email';
    }

    /**
     * {@inheritdoc}
     *
     * @param \PlanB\Robo\Services\Context\ConstraintList $constraintList
     */
    public function configConstraintList(ConstraintList $constraintList): void
    {
        $email = new Email();
        $email->message = 'Se esperaba una dirección de correo electrónico';
        $constraintList->addConstraint($email);
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
        return getenv('USER_EMAIL');
    }
}
