<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

use PlanB\Robo\Services\Exception\BadFormedJsonException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Webmozart\Assert\Assert;

/**
 * Clase que nos permite leer y escribir valores de composer.json.
 */
class ComposerFile
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccess;

    /**
     * @var array<mixed>
     */
    private $contents;

    /**
     * @var string
     */
    private $composerPath;

    /**
     * @var bool
     */
    private $changed = false;

    /**
     * @var array<string>
     */
    private $keyOrder = [];


    /**
     * ComposerInfo constructor.
     *
     * @param string $composerPath
     */
    public function __construct(string $composerPath)
    {

        Assert::fileExists($composerPath);
        $this->initialize($composerPath);

        $defaults = [
            '[config][optimize-autoloader]' => true,
            '[config][sort-packages]' => true,
            '[config][apcu-autoloader]' => true,
            '[config][bin-dir]' => 'bin',
        ];

        $this->apply($defaults);
        $this->populateSortedKeys();
    }

    /**
     * Inicia los atributos del objeto.
     *
     * @param string $composerPath
     */
    private function initialize(string $composerPath): void
    {
        $json = file_get_contents($composerPath);

        $this->composerPath = $composerPath;
        $this->contents = json_decode($json, true);

        if (!is_array($this->contents)) {
            throw  BadFormedJsonException::create($composerPath);
        }

        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Define un array con el orden en el que deben aparecer las claves del fichero composer.json.
     */
    private function populateSortedKeys(): void
    {
        $this->keyOrder[] = 'name';
        $this->keyOrder[] = 'description';
        $this->keyOrder[] = 'version';
        $this->keyOrder[] = 'type';
        $this->keyOrder[] = 'keywords';
        $this->keyOrder[] = 'homepage';
        $this->keyOrder[] = 'license';
        $this->keyOrder[] = 'authors';
        $this->keyOrder[] = 'support';
        $this->keyOrder[] = 'require';
        $this->keyOrder[] = 'require-dev';
        $this->keyOrder[] = 'conflict';
        $this->keyOrder[] = 'replace';
        $this->keyOrder[] = 'provide';
        $this->keyOrder[] = 'suggest';
        $this->keyOrder[] = 'autoload';
        $this->keyOrder[] = 'autoload-dev';
        $this->keyOrder[] = 'autoload-dev';
        $this->keyOrder[] = 'minimum-stability';
        $this->keyOrder[] = 'prefer-stable';
        $this->keyOrder[] = 'config';
        $this->keyOrder[] = 'scripts';
        $this->keyOrder[] = 'extra';
        $this->keyOrder[] = 'bin';
        $this->keyOrder[] = 'repositories';
    }

    /**
     * @param array<string> $values Configura el apartado config para optimizar composer.
     */
    private function apply(array $values): void
    {
        foreach ($values as $key => $value) {
            if ($this->get($key)) {
                continue;
            }

            $this->set($key, $value);
        }
    }

    /**
     * Devuelve el valor que corresponde a un path.
     *
     * @param string $path
     *
     * @return mixed
     */
    public function get(string $path)
    {
        return $this->propertyAccess->getValue($this->contents, $path);
    }

    /**
     * Añade una entrada al apartado autoload/psr-4
     *
     * @param string $namespace
     * @param string $dirname
     *
     * @return \PlanB\Robo\Services\ComposerFile
     */
    public function addAutoloadPsr4(string $namespace, string $dirname): self
    {
        if ($this->has('[autoload][psr-4]')) {
            return $this;
        }

        $key = sprintf('[autoload][psr-4][%s]', $namespace);
        $value = sprintf('src/%s', $dirname);

        $this->set($key, $value);

        return $this;
    }

    /**
     * Asigna un valor a un path.
     *
     * @param string $path
     * @param mixed $value
     *
     * @return \PlanB\Robo\Services\ComposerFile
     */
    public function set(string $path, $value): self
    {
        $this->propertyAccess->setValue($this->contents, $path, $value);
        $this->changed = true;

        return $this;
    }

    /**
     * Indica si un path tiene valor.
     *
     * @param string $path
     *
     * @return bool
     */
    public function has(string $path): bool
    {
        return !is_null($this->get($path));
    }

    /**
     * Guarda los cambios si los hay.
     */
    public function save(): void
    {
        if (!$this->changed) {
            return;
        }

        $this->dumpFile();
    }

    /**
     * Escribe los valores en el fichero composer.json.
     */
    private function dumpFile(): void
    {
        $values = $this->getSortedValues();
        $content = json_encode($values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $fileSystem = new Filesystem();

        $fileSystem->dumpFile($this->composerPath, $content);
    }

    /**
     * Ordena los valores por clave, segun el orden defindo en 'keyOrder'.
     *
     * @return array<mixed>
     */
    private function getSortedValues(): array
    {
        $keys = array_flip($this->keyOrder);
        $contents = $this->contents;

        uksort($contents, static function ($first, $second) use ($keys) {
            $firstWeight = $keys[$first] ?? 100;
            $secondWeight = $keys[$second] ?? 100;

            return $firstWeight - $secondWeight;
        });

        return $contents;
    }
}
