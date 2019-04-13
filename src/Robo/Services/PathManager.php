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
use Webmozart\PathUtil\Path;

class PathManager
{
    /**
     * @var string
     */
    private $pathToProject;

    public function __construct(string $pathToProject)
    {
        $this->pathToProject = realpath($pathToProject);
    }

    public function resolve(string $path)
    {
        $count = 0;
        $patterns = $this->getPatterns();
        $replacements = $this->getReplacements();

        $resolvedPath = preg_replace($patterns, $replacements, $path, -1, $count);

        if ($count !== 1) {
            $available = $this->getAvaiables();
            throw  PathException::fromPath($path, $available);
        }

        return $resolvedPath;
    }

    private function getSubstitutions(): array
    {
        $pathToProject = $this->pathToProject;

        $pathToPlanB = Path::join($pathToProject, '.planb');
        $pathToSource = Path::join($pathToProject, 'src');
        $pathToTests = Path::join($pathToProject, 'tests');

        return [
            '@config/' => $pathToPlanB,
            '@tests/' => $pathToTests,
            '@@/' => $pathToSource,
            '@/' => $pathToProject
        ];
    }

    private function getAvaiables()
    {
        $substitutions = $this->getSubstitutions();
        return array_keys($substitutions);
    }

    private function getPatterns()
    {
        $substitutions = $this->getSubstitutions();
        $patterns = array_keys($substitutions);

        return array_map(function ($pattern) {
            return sprintf('#^%s#', $pattern);
        }, $patterns);

    }

    private function getReplacements(): array
    {
        $substitutions = $this->getSubstitutions();

        return array_map(function ($value) {
            return sprintf('%s/', $value);
        }, $substitutions);
    }
}