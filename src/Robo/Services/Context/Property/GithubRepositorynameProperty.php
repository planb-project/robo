<?php

/**
 * This file is part of the planb project.
 *
 * (c) jmpantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PlanB\Robo\Services\Context\Property;


use PlanB\Robo\Services\Context\Property;

class GithubRepositorynameProperty extends Property
{
    public function getPath(): string
    {
        return '[extra][github_repository]';

    }

    public function getPrompt(): string
    {
        return 'Github Repository Name';
    }

}