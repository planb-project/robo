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

use PlanB\Robo\Services\GitManager;
use Robo\Collection\CollectionBuilder;
use Webmozart\Assert\Assert;

/**
 * Métodos relacionados con el control de versiones
 */
trait Version
{
    /**
     * Devuelve un objeto GitManager
     *
     * @return \PlanB\Robo\Services\GitManager
     */
    abstract public function getGitManager(): GitManager;

    /**
     * Devuelve el la próxima versión, sin modificar el archivo .semver
     *
     * @param string $what
     *
     * @return string
     */
    protected function nextVersion(string $what): string
    {
        Assert::oneOf($what, ['major', 'minor', 'patch']);

        $semver = $this->taskSemVer(self::SEMVER_FILE);

        return $semver->increment($what)->__toString();
    }

    /**
     * Actualiza el archivo .semver
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     * @param string $version
     */
    protected function updateVersion(CollectionBuilder $collection, string $version): void
    {
        $version = preg_replace('/^v/', '', $version);

        $collection->addTaskList([
            $this->taskSemVer(self::SEMVER_FILE)
                ->version($version),

            $this->taskGitStack()
                ->stopOnFail()
                ->add(self::SEMVER_FILE),
        ]);
    }

    /**
     * Prepara un release | hotfix antes de ser finalizado
     *  - actualiza la documentación
     *  - actualiza el archivo changelog
     *  - actualiza el archivo .semver
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     * @param string $version
     *
     * @throws \Exception
     */
    protected function prepareTag(CollectionBuilder $collection, string $version): void
    {
        $issues = $this->getLastIssuesOrFail();
        $this->updateDocs($collection);
        $this->updateChangelog($collection, $version, $issues);
        $this->updateVersion($collection, $version);
    }

    /**
     * Devuelve una lista de los comits con un Issue desde el último tag
     *
     * @return array<string>
     *
     * @throws \Exception
     */
    private function getLastIssuesOrFail(): array
    {
        $issues = $this->getGitManager()->getIssues();

        if (0 === count($issues)) {
            throw new \Exception('there are no issue commits from the last tag');
        }

        $console = new \League\CLImate\CLImate();
        $input = $console->checkboxes('Elige los issues', $issues);

        return $input->prompt();
    }

    /**
     * Actualiza el archivo ChageLog
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     * @param string $version
     * @param array<string> $issues
     */
    private function updateChangelog(CollectionBuilder $collection, string $version, array $issues): void
    {
        Assert::notEmpty($issues);


        $collection->addTaskList([
            $this->taskChangelog(self::CHANGELOG_FILE)
                ->version($version)
                ->changes($issues),

            $this->taskGitStack()
                ->stopOnFail()
                ->add(self::CHANGELOG_FILE),
        ]);
    }

    /**
     * Actualiza la documentación
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    private function updateDocs(CollectionBuilder $collection): void
    {
        $collection->addTaskList([
            $this->taskExec('sami')
                ->arg('update')
                ->arg('.sami.php'),

            $this->taskGitStack()
                ->stopOnFail()
                ->add(self::DOCS_DIR),
        ]);
    }

    /**
     * Devuelve la versión de la release actual
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getReleaseVersion(): string
    {
        return $this->getGitManager()->getTagVersion('release');
    }

    /**
     * Devuelve la versión del hotfix actual
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getHotfixVersion(): string
    {
        return $this->getGitManager()->getTagVersion('hotfix');
    }
}
