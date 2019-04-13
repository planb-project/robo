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

namespace PlanB\Robo\Services;

use PlanB\Robo\Services\Exception\PathException;
use Symfony\Component\Filesystem\Filesystem;
use Webmozart\PathUtil\Path;

/**
 * Gestiona las rutas del proyecto
 */
class PathManager
{
    /**
     * @var string
     */
    private $pathToProject;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fileSystem;


    /**
     * PathManager constructor.
     *
     * @param string $pathToProject
     */
    public function __construct(string $pathToProject)
    {
        $this->pathToProject = realpath($pathToProject);
        $this->fileSystem = new Filesystem();
    }

    /**
     * Resuelve una ruta
     *
     * @param string $path
     *
     * @return string|array<string>|null
     */
    public function resolve(string $path)
    {
        $count = 0;
        $patterns = $this->getPatterns();
        $replacements = $this->getReplacements();

        $resolvedPath = preg_replace($patterns, $replacements, $path, -1, $count);

        if (1 !== $count) {
            $available = $this->getPrefixNames();

            throw  PathException::invalidPrefix($path, $available);
        }

        return $resolvedPath;
    }

    /**
     * Devuelve los prefijos
     *
     * @return array<string>
     */
    private function getPrefixes(): array
    {
        $pathToProject = $this->pathToProject;

        $pathToPlanB = Path::join($pathToProject, '.planb');
        $pathToSource = Path::join($pathToProject, 'src');
        $pathToTests = Path::join($pathToProject, 'tests');

        return [
            '@config/' => $pathToPlanB,
            '@tests/' => $pathToTests,
            '@@/' => $pathToSource,
            '@/' => $pathToProject,
        ];
    }

    /**
     * Devuelve una lista con los nombres de los prefijos
     *
     * @return array<string>
     */
    private function getPrefixNames(): array
    {
        $prefixes = $this->getPrefixes();

        return array_keys($prefixes);
    }

    /**
     * Devuelve una lista con los patrones para hacer la sustituciones
     *
     * @return array<string>
     */
    private function getPatterns(): array
    {

        $prefixNames = $this->getPrefixNames();

        return array_map(static function ($prefix) {
            return sprintf('#^%s#', $prefix);
        }, $prefixNames);
    }

    /**
     * Devuelve una lista con los valores de reemplazo  para hacer las sustituciones
     *
     * @return array<string>
     */
    private function getReplacements(): array
    {
        $values = $this->getPrefixes();

        return array_map(static function ($value) {
            return sprintf('%s/', $value);
        }, $values);
    }

    /**
     * Devuelve un objeto ComposerFile
     *
     * @param string $path
     *
     * @return \PlanB\Robo\Services\ComposerFile
     */
    public function getComposerFile(string $path = '@/composer.json'): ComposerFile
    {
        $path = $this->resolve($path);

        if (!$this->fileSystem->exists($path)) {
            $this->fileSystem->dumpFile($path, '{}');
        }

        return new ComposerFile($path);
    }
}
