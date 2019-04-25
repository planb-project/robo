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

/**
 * Métodos relacionados con el control de calidad
 */
trait QualityAssurance
{

    /**
     * Soluciona los errores de formato que puedan arreglarse automáticamente
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     * @param string $dir
     */
    protected function fixQuality(CollectionBuilder $collection, string $dir = 'src'): void
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

    /**
     * Comprueba la calidad del código
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     * @param string $dir
     */
    protected function checkQuality(CollectionBuilder $collection, string $dir = 'src'): void
    {
        if (!$this->thereArePhpFiles($dir)) {
            return;
        }

        $tools = implode(',', $this->getQualityTools());
        $collection->addTaskList([
            $this->taskExec('phpqa')
                ->option('analyzedDirs', $dir)
                ->option('ignoredDirs', './vendor')
                ->option('config', '.')
                ->option('tools', $tools)
                ->option('buildDir', './build/logs')
                ->option('report'),
        ]);
    }

    /**
     * Devuelve la lista de herramietas de qa que vamos a aplicar
     *
     * @return array<string>
     */
    abstract public function getQualityTools(): array;

    /**
     * Ejecuta todos los tests
     *
     * @param \Robo\Collection\CollectionBuilder $collection
     */
    protected function runAllTests(CollectionBuilder $collection): void
    {

        $collection->addTaskList([
            $this->taskExec('bin/behat'),
            $this->taskExec('bin/phpspec')->arg('run'),
        ]);
    }

    /**
     * Indica si hay archivos php un directorio
     *
     * @param string $dir
     *
     * @return bool
     */
    private function thereArePhpFiles(string $dir): bool
    {
        $finder = new Finder();
        $total = $finder->files()->name('*.php')->in($dir)->count();

        return $total > 0;
    }
}
