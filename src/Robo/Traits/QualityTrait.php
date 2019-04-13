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
use Symfony\Component\Finder\Finder;

trait QualityTrait
{
    protected function fixQuality(CollectionBuilder $collection, $dir = 'src')
    {
        if (!$this->thereArePhpFiles($dir)) {
            return;
        }

        $collection->addTaskList([

            $this->taskExec('phpqa')
                ->option('analyzedDirs', $dir)
                ->option('ignoredDirs', './vendor')
                ->option('config', '.')
                ->option('tools', 'phpcbf'),
        ]);

    }

    protected function checkQuality(CollectionBuilder $collection, $dir = 'src')
    {

        if (!$this->thereArePhpFiles($dir)) {
            return;
        }

        $collection->addTaskList([
            $this->taskExec('phpqa')
                ->option('analyzedDirs', $dir)
                ->option('ignoredDirs', './vendor')
                ->option('config', '.')
                //->option('tools', 'parallel-lint,phpcbf,phpcs,phploc,phpmd,pdepend,phpcpd,security-checker,phpmetrics')
                ->option('tools', 'parallel-lint,phpcs,phploc,phpmd,pdepend,phpcpd,security-checker')
                ->option('buildDir', './build/logs')
                ->option('report')
        ]);

    }

    protected function runAllTests(CollectionBuilder $collection)
    {

        $collection->addTaskList([
            $this->taskExec('bin/behat'),
            $this->taskExec('bin/phpspec')->arg('run'),
        ]);

    }

    /**
     * @param $dir
     * @return int
     */
    protected function thereArePhpFiles(string $dir): bool
    {
        $finder = new Finder();
        $total = $finder->files()->name('*.php')->in($dir)->count();

        return $total > 0;
    }
}