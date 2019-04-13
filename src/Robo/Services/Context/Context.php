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

namespace PlanB\Robo\Services\Context;


use PlanB\Robo\Services\Context\Property\PackageNameProperty;
use Traversable;

class Context implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $values;
    private $iterator;

    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }

        $this->populate();
    }

    private function set(string $key, string $value): self
    {
        $this->values[":$key"] = $value;
        return $this;
    }

    public function get(string $key): ?string
    {
        return $this->values[$key] ?? null;
    }

    /**
     * @param string $content
     * @return string
     */
    public function replace(string $content): string
    {
        foreach ($this as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        return $content;
    }

    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->populate();
            $this->iterator = new \ArrayIterator($this->values);
        }

        return $this->iterator;
    }

    private function populate()
    {
        $matches = [];
        $name = $this->values[':package_name'] ?? '';

        if (preg_match(PackageNameProperty::PATTERN, $name, $matches)) {
            list(, $vendor, $package) = $matches;
            $this->addValues($vendor, $package);
        }
    }

    /**
     * @param $vendor
     * @param $package
     */
    private function addValues(string $vendor, string $package): void
    {
        $vendor = $this->normalize($vendor);
        if(getenv('VENDOR')){
            $vendor = getenv('VENDOR');
        }

        $this->set('vendor', $vendor);
        $this->set('package_name', $package);

        $package = $this->normalize($package);

        $this->set('namespace', sprintf('%s\%s\\', $vendor, $package));
        $this->set('path_to_namespace', ucfirst($package));
    }

    private function normalize(string $value): string
    {
        $pieces = preg_split('/\W/', $value);

        $value = array_pop($pieces);
        $value = strtolower($value);

        if (strlen($value) <= 2) {
            return strtoupper($value);
        }

        return ucfirst($value);
    }
}