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

/**
 * métodos para inicializar las distintas herramientas
 */
trait InitProject
{
    /**
     * Inicializa phpqa
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initQa(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/.phpcs.xml', '@/.phpcs.xml')
                ->file('@config/.phpmd.xml', '@/.phpmd.xml')
                ->file('@config/.phpqa.yml', '@/.phpqa.yml'),
        ]);
    }

    /**
     * Inicializa sami
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initSami(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->dir('@/var')
                ->dir('@/docs')
                ->file('@config/sami.php', '@/.sami.php'),
        ]);
    }

    /**
     * Inicializa la configuración de ci (travis y scrutinizer)
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initCi(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/templates/.scrutinizer.yml', '@/.scrutinizer.yml')
                ->file('@config/templates/.travis.yml', '@/.travis.yml'),
        ]);
    }

    /**
     * Inicializa composer con las dependencias minimas
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     *
     * @throws \Robo\Exception\TaskException
     */
    protected function initComposer(CollectionBuilder $collection): void
    {
        $devPackages = $this->getDevPackages();
        $packages = $this->getPackages();

        $taskList = [
            $this->requireDependency($packages),
            $this->requireDevDependency($devPackages),
        ];

        $collection->addTaskList(array_filter($taskList));
    }

    /**
     * Actualiza las dependencias de composer
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function composerUpdate(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskComposerUpdate(),
            $this->taskComposerValidate(),
        ]);
    }

    /**
     * Devuelve una tarea RequireDepencency con los paquetes indicados
     * o null si no se indica ningun paquete
     *
     * @param array<string> $packages
     *
     * @return \Robo\Task\Composer\RequireDependency|null
     *
     * @throws \Robo\Exception\TaskException
     */
    private function requireDependency(array $packages): ?RequireDependency
    {
        if (0 === count($packages)) {
            return null;
        }

        $task = new RequireDependency('composer');
        $task->option('no-update');

        foreach ($packages as $package) {
            $task->dependency($package);
        }

        return $task;
    }

    /**
     * Devuelve una tarea RequireDepencency para dev con los paquetes indicados
     * o null si no se indica ningun paquete
     *
     * @param array<string> $packages
     *
     * @return \Robo\Task\Composer\RequireDependency|null
     *
     * @throws \Robo\Exception\TaskException
     */
    private function requireDevDependency(array $packages): ?RequireDependency
    {
        $task = $this->requireDependency($packages);

        if ($task instanceof RequireDependency) {
            $task->dev();
        }

        return $task;
    }

    /**
     * Inicializa Behat
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initBehat(CollectionBuilder $collection): void
    {
        $taskList = [
            $this->taskComposerRequire()->dependency('behat/behat')->dev(),

            $this->taskBoilerplate()
                ->file('@config/templates/behat.yml', '@/behat.yml'),

            $this->taskExec('bin/behat')
                ->option('init'),
        ];

        $collection->addTaskList(array_filter($taskList));
    }

    /**
     * Inicializa phpspec
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     *
     * @throws \Robo\Exception\TaskException
     */
    protected function initPhpSpec(CollectionBuilder $collection): void
    {
        $taskList = [

            $this->taskComposerConfig()
                ->repository(0, 'https://github.com/shulard/phpspec-code-coverage.git', 'vcs'),

            $this->taskComposerRequire()
                ->dev()
                ->dependency('phpspec/phpspec')
                ->dependency('memio/spec-gen')
                ->dependency('ciaranmcnulty/phpspec-typehintedmethods')
                ->dependency('leanphp/phpspec-code-coverage', 'dev-upgrade'),


            $this->taskBoilerplate()
                ->dir('@/.phpspec')
                ->file('@config/templates/phpspec.yml', '@/phpspec.yml')
                ->file('@config/templates/phpspec/class.tpl', '@/.phpspec/class.tpl'),
        ];

        $collection->addTaskList(array_filter($taskList));
    }

    /**
     * Inicializa los archivos con meta información sobre el proyecto
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initProject(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->dir('@@/:path_to_namespace')
                ->file('@config/templates/.editorconfig', '@/.editorconfig')
                ->file('@config/templates/.semver', '@/.semver')
                ->file('@config/templates/CHANGELOG.md', '@/CHANGELOG.md')
                ->file('@config/templates/license/:license.md', '@/LICENSE.md')
                ->file('@config/templates/README.md', '@/README.md')
                ->file('@config/templates/.gitattributes', '@/.gitattributes')
                ->file('@config/templates/.gitignore', '@/.gitignore'),
        ]);
    }

    /**
     * Inicializa los archivos con meta información sobre el proyecto
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initMetadata(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/templates/CODE_OF_CONDUCT.md', '@/CODE_OF_CONDUCT.md')
                ->file('@config/templates/CONTRIBUTING.md', '@/CONTRIBUTING.md')
                ->file('@config/templates/CODE_OF_CONDUCT.md', '@/CODE_OF_CONDUCT.md')
                ->file('@config/templates/ISSUE_TEMPLATE.md', '@/ISSUE_TEMPLATE.md')
                ->file('@config/templates/PULL_REQUEST_TEMPLATE.md', '@/PULL_REQUEST_TEMPLATE.md'),
        ]);
    }

    /**
     * Inicializa git
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initGit(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/templates/.gitattributes', '@/.gitattributes')
                ->file('@config/templates/.gitignore', '@/.gitignore'),
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

    /**
     * Inicializa los hooks de git
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function initHooks(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskBoilerplate()
                ->file('@config/hooks/pre-commit', '@/.git/hooks/pre-commit')
                ->file('@config/hooks/commit-msg', '@/.git/hooks/commit-msg'),

            $this->taskExec('chmod')->args(['-R', '+x', '.git/hooks']),
        ]);
    }

    /**
     * Devuelve la lista de dependencias para dev
     *
     * @return array<string>
     */
    abstract public function getDevPackages(): array;

    /**
     * Devuelve la lista de dependencias
     *
     * @return array<string>
     */
    abstract public function getPackages(): array;
}
