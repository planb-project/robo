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

use PlanB\Robo\Services\GitManager;
use Robo\Tasks;

/**
 * Robo File Base
 */
abstract class RoboBase extends Tasks
{

    use \PlanB\Robo\Traits\GitFlow;
    use \PlanB\Robo\Traits\Version;
    use \PlanB\Robo\Traits\InitProject;
    use \PlanB\Robo\Traits\QualityAssurance;

    protected const FEATURE = 'feature/';
    protected const RELEASE = 'release/';
    protected const HOTFIX = 'hotfix/';

    protected const DOCS_DIR = 'docs';
    protected const CHANGELOG_FILE = 'CHANGELOG.md';
    protected const SEMVER_FILE = '.semver';

    /**
     * @var \PlanB\Robo\Services\GitManager|null
     */
    private $gitManager;

    /**
     * RoboBase constructor.
     */
    public function __construct()
    {

        $this->gitManager = new GitManager();
    }

    /**
     * Devuelve un objeto GitManager
     *
     * @return \PlanB\Robo\Services\GitManager
     */
    public function getGitManager(): GitManager
    {
        return $this->gitManager;
    }
}
