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
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class AuthorEmailProperty extends Property implements ValidablePropertyInterface
{
    public function getPath(): string
    {
        return '[authors][0][email]';
    }

    public function getPrompt(): string
    {
        return 'Author Email';
    }

    /**
     * @return array<Constraint>
     */
    public function configConstraintList(ConstraintList $constraintList): void
    {
        $email = new Email();
        $email->message = 'Se esperaba una dirección de correo electrónico';
        $constraintList->addConstraint($email);
    }

    public function getDefault(array $context): ?string
    {
        return getenv('USER_EMAIL');
    }
}
