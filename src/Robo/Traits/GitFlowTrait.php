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

trait GitFlowTrait
{

    use \Globalis\Robo\Task\GitFlow\loadTasks;

    protected function startFeature(CollectionBuilder $collection, string $name): void
    {
        $collection->addTaskList([
            $this->taskFeatureStart($name)
                ->developBranch('develop')
                ->repository('origin')
                ->prefixBranch(self::FEATURE)
                ->fetchFlag(true)
        ]);
    }

    protected function finishFeature(CollectionBuilder $collection, string $name): void
    {
        $collection->addTaskList([
            $this->taskFeatureFinish($name)
                ->developBranch('develop')
                ->repository('origin')
                ->fetchFlag(true)
                ->rebaseFlag(true)
                ->deleteBranchAfter(true)
                ->prefixBranch(self::FEATURE)
                ->pushFlag(true)
        ]);

    }


    protected function startRelease(CollectionBuilder $collection, string $tagName)
    {
        if ($this->thereAreAnyReleaseOrHotfix()) {
            throw new \Exception('it is not possible to create a release while there are any release o hotfix started');
        }

        $collection->addTaskList([
            $this->taskReleaseStart($tagName)
                ->developBranch('develop')
                ->repository('origin')
                ->fetchFlag(true)
                ->prefixBranch(self::RELEASE)
        ]);
    }


    protected function finishRelease(CollectionBuilder $collection, string $tagName)
    {
        $collection->addTaskList([
            $this->taskGitStack()
                ->stopOnFail()
                ->commit(sprintf('release %s created', $tagName), '-n'),

            $this->taskReleaseFinish($tagName)
                ->developBranch('develop')
                ->masterBranch('master')
                ->repository('origin')
                ->fetchFlag(true)
                ->rebaseFlag(true)
                ->deleteBranchAfter(true)
                ->prefixBranch(self::RELEASE)
                ->noTag(false)
                ->tagMessage(sprintf('tag %s created', $tagName))
                ->pushFlag(true)

        ]);

    }

    protected function startHotfix(CollectionBuilder $collection, string $tagName)
    {
        if ($this->thereAreAnyReleaseOrHotfix()) {
            throw new \Exception('it is not possible to create a hotfix while there are any release o hotfix started');
        }

        $collection->addTaskList([
            $this->taskHotfixStart($tagName)
                ->masterBranch('master')
                ->repository('origin')
                ->fetchFlag(true)
                ->prefixBranch(self::HOTFIX)
        ]);
    }

    protected function finishHotfix(CollectionBuilder $collection, string $tagName)
    {

        $collection->addTaskList([
            $this->taskGitStack()
                ->stopOnFail()
                ->commit(sprintf('hotfix %s created', $tagName), '-n'),

            $this->taskHotfixFinish($tagName)
                ->developBranch('develop')
                ->masterBranch('master')
                ->repository('origin')
                ->fetchFlag(true)
                ->rebaseFlag(true)
                ->deleteBranchAfter(true)
                ->prefixBranch(self::HOTFIX)
                ->noTag(false)
                ->tagMessage(sprintf('tag %s created', $tagName))
                ->pushFlag(true)

        ]);

    }
}