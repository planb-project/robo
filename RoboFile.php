<?php

use \Webmozart\Assert\Assert;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \PlanB\Robo\RoboBase
{

    use \PlanB\Robo\Task\LoadTasks;

    public function getDevPackages(): array
    {
        return [
            'symfony/var-dumper'
        ];

    }

    public function getPackages(): array
    {
        return [
            'webmozart/assert',
            'ramsey/uuid',
            'marc-mabe/php-enum'
        ];
    }

    public function init()
    {
        $collection = $this->collectionBuilder();

        $this->initQa($collection);
        $this->initSami($collection);
        $this->initCi($collection);
        $this->initComposer($collection);
        $this->initBehat($collection);
        $this->initPhpSpec($collection);
        $this->initProject($collection);
        $this->initGit($collection);
        $this->initHooks($collection);
        $this->composerUpdate($collection);

        return $collection->run();
    }

    public function featureStart(string $name)
    {
        $collection = $this->collectionBuilder();

        $this->startFeature($collection, $name);

        return $collection->run();
    }

    public function featureFinish(string $name)
    {
        $collection = $this->collectionBuilder();
        $this->finishFeature($collection, $name);

        return $collection->run();

    }

    public function releaseStart($what = 'minor')
    {
        Assert::oneOf($what, ['major', 'minor']);

        $collection = $this->collectionBuilder();
        $version = $this->nextVersion($what);

        $this->startRelease($collection, $version);

        return $collection->run();
    }

    public function releaseFinish()
    {
        $collection = $this->collectionBuilder();
        $version = $this->getReleaseVersion();

        $this->prepareTag($collection, $version);
        $this->finishRelease($collection, $version);

        return $collection->run();
    }


    public function hotfixStart()
    {
        $collection = $this->collectionBuilder();

        $version = $this->nextVersion('patch');

        $this->startHotfix($collection, $version);
        return $collection->run();
    }

    public function hotfixFinish()
    {

        $collection = $this->collectionBuilder();
        $version = $this->getHotfixVersion();

        $this->prepareTag($collection, $version);
        $this->finishHotfix($collection, $version);

        return $collection->run();
    }

    public function qaCheck($dir = 'src')
    {

        $collection = $this->collectionBuilder();
        $this->fixQuality($collection, $dir);
        $this->checkQuality($collection, $dir);

        return $collection->run();
    }

    public function runTests()
    {
        $collection = $this->collectionBuilder();
        $this->runAllTests($collection);

        return $collection->run();
    }

    public function qualityAssurance()
    {
        $collection = $this->collectionBuilder();

        $this->checkQuality($collection, 'src');
        $this->runAllTests($collection);

        return $collection->run();
    }
}
