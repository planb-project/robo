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

namespace PlanB\Robo\Traits;

use Robo\Collection\CollectionBuilder;
use Robo\Task\Composer\RequireDependency;

trait InitTrait
{
    protected function initQa(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/.phpcs.xml', '@/.phpcs.xml')
                ->file('@config/.phpmd.xml', '@/.phpmd.xml')
                ->file('@config/.phpqa.yml', '@/.phpqa.yml')
        ]);
    }

    protected function initSami(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/sami.php', '@/.sami.php')
        ]);
    }

    protected function initCi(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/templates/.scrutinizer.yml', '@/.scrutinizer.yml')
                ->file('@config/templates/.travis.yml', '@/.travis.yml')
        ]);
    }

    protected function initComposer(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskComposerValidate()
        ]);

        $devPackages = $this->getDevPackages();
        $packages = $this->getPackages();

        $taskList = [
            $this->requireDependency($packages),
            $this->requireDevDependency($devPackages)
        ];

        $collection->addTaskList(array_filter($taskList));

    }

    protected function composerUpdate(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskComposerUpdate()
        ]);
    }

    private function requireDependency(array $packages): ?RequireDependency
    {
        if (empty($packages)) {
            return null;
        }

        $task = new RequireDependency('composer');
        $task->option('no-update');

        foreach ($packages as $package) {
            $task->dependency($package);
        }
        return $task;

    }

    private function requireDevDependency(array $packages): ?RequireDependency
    {
        $task = $this->requireDependency($packages);
        if ($task instanceof RequireDependency) {
            $task->dev();
        }
        return $task;

    }

    protected function initBehat(CollectionBuilder $collection): void
    {
        $taskList = [
            $this->taskComposerRequire()->dependency('behat/behat'),

            $this->taskBoilerplate()
                ->file('@config/templates/behat.yml', '@/behat.yml'),

            $this->taskExec('bin/behat')
                ->option('init'),
        ];

        $collection->addTaskList(array_filter($taskList));
    }

    protected function initPhpSpec(CollectionBuilder $collection): void
    {
        $taskList = [
            $this->requireDevDependency(['phpspec/phpspec']),

            $this->taskBoilerplate()
                ->dir('@/.phpspec')
                ->file('@config/templates/phpspec.yml', '@/phpspec.yml')
                ->file('@config/templates/phpspec/class.tpl', '@/.phpspec/class.tpl'),

            $this->taskExec('bin/behat')
                ->option('init'),
        ];

        $collection->addTaskList(array_filter($taskList));
    }


    protected function initProject(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->dir('@/var')
                ->dir('@/docs')
                ->dir('@@/:path_to_namespace')
                ->file('@config/templates/.editorconfig', '@/.editorconfig')
                ->file('@config/templates/.semver', '@/.semver')
                ->file('@config/templates/CHANGELOG.md', '@/CHANGELOG.md')
                ->file('@config/templates/CODE_OF_CONDUCT.md', '@/CODE_OF_CONDUCT.md')
                ->file('@config/templates/CONTRIBUTING.md', '@/CONTRIBUTING.md')
                ->file('@config/templates/CODE_OF_CONDUCT.md', '@/CODE_OF_CONDUCT.md')
                ->file('@config/templates/ISSUE_TEMPLATE.md', '@/ISSUE_TEMPLATE.md')
                ->file('@config/templates/license/:license.md', '@/LICENSE.md')
                ->file('@config/templates/PULL_REQUEST_TEMPLATE.md', '@/PULL_REQUEST_TEMPLATE.md')
                ->file('@config/templates/README.md', '@/README.md')
        ]);


    }

    protected function initGit(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/templates/.gitattributes', '@/.gitattributes')
                ->file('@config/templates/.gitignore', '@/.gitignore')
        ]);

        if (is_file('.git/config')) {
            return;
        }

        $collection->addTaskList([
            $this->taskExec('git init'),
            $this->taskBoilerplate()
                ->file('@config/templates/git/config', '@/.git/config', true),

            $this->taskGitStack()
                ->stopOnFail()
                ->add('.')
                ->commit('Issue #0. First Commit')
                ->push('origin', 'master'),

            $this->taskExec('git ')->args(['branch', 'develop']),

        ]);

    }

    protected function initHooks(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/hooks/pre-commit', '@/.git/hooks/pre-commit')
                ->file('@config/hooks/commit-msg', '@/.git/hooks/commit-msg'),

            $this->taskExec('chmod')->args(['-R', '+x', '.git/hooks'])
        ]);
    }

    abstract public function getDevPackages(): array;

    /**
     * @return array
     */
    abstract public function getPackages(): array;

}
