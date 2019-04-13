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

trait VersionTrait
{
    abstract public function getGitManager(): GitManager;

    protected function nextVersion(string $what): string
    {
        Assert::oneOf($what, ['major', 'minor', 'patch']);

        $semver = $this->taskSemVer(self::SEMVER_FILE);
        return $semver->increment($what)->__toString();
    }

    protected function updateVersion(CollectionBuilder $collection, string $version)
    {
        $version = preg_replace('/^v/', '', $version);

        $collection->addTaskList([
            $this->taskSemVer(self::SEMVER_FILE)
                ->version($version),

            $this->taskGitStack()
                ->stopOnFail()
                ->add(self::SEMVER_FILE)
        ]);
    }

    protected function prepareTag($collection, $version): void
    {
        $issues = $this->getLastIssuesOrFail();
        $this->updateDocs($collection);
        $this->updateChangelog($collection, $version, $issues);
        $this->updateVersion($collection, $version);
    }


    private function getLastIssuesOrFail()
    {
        $issues = $this->getGitManager()->getIssues();

        if (empty($issues)) {
            throw new \Exception('there are no issue commits from the last tag');
        }

        $console = new \League\CLImate\CLImate();
        $input = $console->checkboxes('Elige los issues', $issues);

        return $input->prompt();
    }

    protected function updateChangelog(CollectionBuilder $collection, string $version, array $issues)
    {
        Assert::notEmpty($issues);


        $collection->addTaskList([
            $this->taskChangelog(self::CHANGELOG_FILE)
                ->version($version)
                ->changes($issues),

            $this->taskGitStack()
                ->stopOnFail()
                ->add(self::CHANGELOG_FILE)
        ]);
    }


    protected function updateDocs(CollectionBuilder $collection)
    {
        $collection->addTaskList([
            $this->taskExec('sami')
                ->arg('update')
                ->arg('.sami.php'),

            $this->taskGitStack()
                ->stopOnFail()
                ->add(self::DOCS_DIR)
        ]);
    }


    protected function thereAreAnyReleaseOrHotfix(): bool
    {
        $releases = $this->getGitManager()->getBranches(self::RELEASE);
        $hotfixes = $this->getGitManager()->getBranches(self::HOTFIX);
        return count($releases) > 0 || count($hotfixes) > 0;
    }

    protected function getReleaseVersion()
    {
        return $this->getGitManager()->getTagVersion('release');
    }

    protected function getHotfixVersion()
    {
        return $this->getGitManager()->getTagVersion('hotfix');
    }

}