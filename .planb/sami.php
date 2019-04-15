<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->in($dir = 'src');

// generate documentation for all v2.0.* tags, the 2.0 branch, and the master one
$versions = GitVersionCollection::create($dir)
//    ->addFromTags('v2.0.*')
    ->add('develop', 'develop branch')
    ->add('master', 'master branch');

return new Sami($iterator, array(
    'theme' => 'markdown',
//    'versions'             => $versions,
    'title' => 'Symfony2 API',
    'build_dir' => './docs/%version%',
    'cache_dir' => './var/cache/sami/%version%',
    'template_dirs' => ['/robo/views/sami/markdown'],
//    'remote_repository'    => new GitHubRemoteRepository('symfony/symfony', dirname($dir)),
    'default_opened_level' => 2,
));
