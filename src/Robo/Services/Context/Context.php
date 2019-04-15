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

/**
 * Una colección con las variables del contexto
 */
class Context implements \IteratorAggregate
{
    /**
     * @var array<mixed>
     */
    private $values;
    /**
     * @var \ArrayIterator
     */
    private $iterator;

    /**
     * Context constructor.
     *
     * @param array<string> $values
     */
    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }

        $this->autoComplete();
    }

    /**
     * Asigna un valor
     *
     * @param string $key
     * @param string $value
     *
     * @return \PlanB\Robo\Services\Context\Context
     */
    private function set(string $key, string $value): self
    {
        $this->values[":$key"] = $value;

        return $this;
    }

    /**
     * Devuelve un valor
     *
     * @param string $key
     *
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->values[$key] ?? null;
    }

    /**
     * Reemplaza los nombres de variable por su valor en una cadena de texto
     *
     * @param string $content
     *
     * @return string
     */
    public function replace(string $content): string
    {
        foreach ($this as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        if (is_null($this->iterator)) {
            $this->autoComplete();
            $this->iterator = new \ArrayIterator($this->values);
        }

        return $this->iterator;
    }

    /**
     * Infiere algunos valores a partir de los existentes
     */
    private function autoComplete(): void
    {
        $this->set('year', date('Y'));

        $matches = [];
        $name = $this->values[':package_name'] ?? '';

        if (!preg_match(PackageNameProperty::PATTERN, $name, $matches)) {
            return;
        }

        [, $vendor, $package] = $matches;

        $this->addValues($vendor, $package);

        $this->addPackageFullName();
        $this->addRepoFullname();
    }

    /**
     * Agrega los valores de vendor y package_name
     *
     * @param string $vendor
     * @param string $package
     */
    private function addValues(string $vendor, string $package): void
    {
        $vendor = $this->normalize($vendor);

        if (getenv('VENDOR')) {
            $vendor = getenv('VENDOR');
        }

        $this->set('vendor', $vendor);
        $this->set('package_name', $package);

        $package = $this->normalize($package);
        $this->set('namespace', sprintf('%s\%s\\', $vendor, $package));
        $this->set('path_to_namespace', ucfirst($package));
    }

    /**
     * Normaliza un valor antes de ser añadido
     *
     * @param string $value
     *
     * @return string
     */
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

    /**
     * Añade la propiedad package_fullname
     */
    private function addPackageFullName(): void
    {
        $vendor = $this->values[':vendor'];
        $package = $this->values[':package_name'];

        $fullName = strtolower(sprintf('%s/%s', $vendor, $package));
        $this->set('package_fullname', $fullName);
    }

    /**
     * Añade la propiedad repository_fullname
     */
    private function addRepoFullname(): void
    {
        $package = $this->values[':package_name'];

        $organization = $this->values[':github_organization'];
        $fullRepoName = strtolower(sprintf('%s/%s', $organization, $package));
        $this->set('repository_fullname', $fullRepoName);
    }
}
