<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Robo\Services\Context;

use PlanB\Robo\Services\Context\Property\AuthorEmailProperty;
use PlanB\Robo\Services\Context\Property\AuthorHomepageProperty;
use PlanB\Robo\Services\Context\Property\AuthorNameProperty;
use PlanB\Robo\Services\Context\Property\GithubOrganizationProperty;
use PlanB\Robo\Services\Context\Property\GithubRepositorynameProperty;
use PlanB\Robo\Services\Context\Property\LicenseProperty;
use PlanB\Robo\Services\Context\Property\PackageDescriptionProperty;
use PlanB\Robo\Services\Context\Property\PackageNameProperty;
use PlanB\Robo\Services\Context\Property\PackageTypeProperty;

/**
 * Gestiona el listado de propiedades
 */
class PropertyList extends \ArrayIterator
{
    /**
     * PropertyList constructor.
     */
    public function __construct()
    {
        $properties = [];

        $properties['author_name'] = AuthorNameProperty::make();
        $properties['author_email'] = AuthorEmailProperty::make();

        $properties['github_organization'] = GithubOrganizationProperty::make();
        $properties['github_repository_name'] = GithubRepositorynameProperty::make();

        $properties['author_website'] = AuthorHomepageProperty::make();

        $properties['package_name'] = PackageNameProperty::make();
        $properties['package_description'] = PackageDescriptionProperty::make();
        $properties['package_type'] = PackageTypeProperty::make();
        $properties['license'] = LicenseProperty::make();

        parent::__construct($properties, 0);
    }
}
