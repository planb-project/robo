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

namespace PlanB\Robo;


use phpDocumentor\Reflection\Types\Parent_;
use PlanB\Robo\Services\GitManager;
use Robo\Tasks;

abstract class RoboBase extends Tasks
{

    use \PlanB\Robo\Traits\GitFlowTrait;
    use \PlanB\Robo\Traits\VersionTrait;
    use \PlanB\Robo\Traits\InitTrait;
    use \PlanB\Robo\Traits\QualityTrait;


    const FEATURE = 'feature/';
    const RELEASE = 'release/';
    const HOTFIX = 'hotfix/';

    const DOCS_DIR = 'docs';
    const CHANGELOG_FILE = 'CHANGELOG.md';
    const SEMVER_FILE = '.semver';

    private $gitmanager = null;

    public function __construct()
    {

        $this->gitmanager = new GitManager();
    }

    public function getGitManager(): GitManager
    {
        return $this->gitmanager;
    }
}
