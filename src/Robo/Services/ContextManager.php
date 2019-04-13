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

use JakubOnderka\PhpParallelLint\ArrayIterator;
use JsonSchema\Constraints\Constraint;
use League\CLImate\CLImate;
use PlanB\Robo\Services\ComposerFile;
use PlanB\Robo\Services\Context\ChoosablePropertyInterface;
use PlanB\Robo\Services\Context\Context;
use PlanB\Robo\Services\Context\NotStorablePropertyInterface;
use PlanB\Robo\Services\Context\PropertyList;
use PlanB\Robo\Services\Context\Property;
use PlanB\Robo\Services\Context\PropertyValidator;
use PlanB\Robo\Services\Context\ValidablePropertyInterface;
use PlanB\Wand\Core\Context\Property\PropertyCollection;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Webmozart\Assert\Assert;

/**
 * Gestiona el contenido de composer.json.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ContextManager
{
    /**
     * @var CLImate
     */
    private $console;

    /**
     * @var \PlanB\Wand\Core\Context\Property[]
     */
    private $properties = [];

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * ContextManager constructor.
     * @param CLImate $console
     */
    public function __construct(ConsoleManager $console)
    {
        $this->console = $console;
        $this->properties = new PropertyList();
        $this->validator = new PropertyValidator();
    }

    /**
     * Devuelve un array con el contexto asociado a un archivo composer.json
     */
    public function parse(ComposerFile $composerFile): Context
    {
        $values = [];
        $this->console->out('Checking composer.json info...');

        foreach ($this->properties as $key => $property) {
            $values[$key] = $this->resolve($property, $composerFile, $values);
        }

        $context = new Context($values);
        $this->applyContext($composerFile, $context);

        $composerFile->save();
        return $context;
    }

    private function applyContext(ComposerFile $composerFile, Context $context)
    {
        $namespace = $context->get(':namespace');
        $dirname = $context->get(':path_to_namespace');

        $composerFile->addAutoloadPsr4($namespace, $dirname);
    }

    /**
     * Devuelve el valor que corresponde a la propiedad pasada.
     *
     * @param \PlanB\Robo\Services\ComposerFile $composerFile
     * @param Property $property
     *
     * @return null|string
     */
    private function resolve(Property $property, ComposerFile $composerFile, array $context): ?string
    {

        $path = $property->getPath();
        $value = $composerFile->get($path);

        while (!$this->validator->validate($value, $property)) {
            $value = $this->console->prompt($property, $context);
        }

        $composerFile->set($path, $value);
        return $value;
    }
}
