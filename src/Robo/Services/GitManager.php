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


class GitManager
{

    public function getIssues()
    {
        $output = [];
        $command = 'git log --tags --simplify-by-decoration --pretty="format:%ci" --max-count=1';
        exec($command, $output);
        $lastTagDate = $output[0] ?? '1900-01-01 00:00:00 +0000';


        $keyword = 'Issue';
        $pattern = sprintf('/.*(%s.*)?/', $keyword);
        $output = [];
        $command = sprintf('git log --all --after="%s" --oneline --grep="%s"', $lastTagDate, $keyword);

        exec($command, $output);

        $issues = array_map(function ($line) use ($pattern) {

            $matches = [];
            if (preg_match('/Issue.*$/', $line, $matches)) {
                return $matches[0];
            }

            return null;
        }, $output);


        return array_filter($issues);
    }

    public function getTagVersion(string $name)
    {
        $pattern = sprintf('#%s/(.*)#', $name);

        $branchesByType = $this->getBranches($name);

        $branches = array_map(function (string $branch) use ($pattern) {
            $matches = [];
            if (preg_match($pattern, $branch, $matches)) {
                return $matches[1];
            };

            return null;
        }, $branchesByType);

        $branches = array_filter($branches);

        if (count($branches) != 1) {
            $message = sprintf("La cantidad o el formato de las ramas %s no es consistente \n%s", $name, var_export($branchesByType, true));
            throw new \Exception($message);
        }

        return array_shift($branches);
    }

    public function getBranches(string $name)
    {
        $output = [];
        $command = sprintf("git branch | grep -i %s", $name);
        exec($command, $output);

        return $output;
    }
}