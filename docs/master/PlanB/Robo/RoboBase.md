
                                                                                                                                            
    
# RoboBase


> Robo File Base
>
> 


## Traits
- PlanB\Robo\Traits\GitFlow
- PlanB\Robo\Traits\Version
- PlanB\Robo\Traits\InitProject
- PlanB\Robo\Traits\QualityAssurance
- Globalis\Robo\Task\GitFlow\loadTasks


## Constants
- FEATURE
- RELEASE
- HOTFIX
- DOCS_DIR
- CHANGELOG_FILE
- SEMVER_FILE




## Methods

### startFeature
Inicia una feature


protected **RoboBase::startFeature**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $name) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$name |  |

---


### finishFeature
Finaliza una feature


protected **RoboBase::finishFeature**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $name) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$name |  |

---


### startRelease
Inicia una release


protected **RoboBase::startRelease**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $tagName) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$tagName |  |

---


### finishRelease
Finaliza una release


protected **RoboBase::finishRelease**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $tagName) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$tagName |  |

---


### startHotfix
Inicia un hotfix


protected **RoboBase::startHotfix**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $tagName) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$tagName |  |

---


### finishHotfix
Finaliza un hotfix


protected **RoboBase::finishHotfix**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $tagName) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$tagName |  |

---


### getGitManager
Devuelve un objeto GitManager


**RoboBase::getGitManager**() : [GitManager](../../GitManager.md)



---


### nextVersion
Devuelve el la próxima versión, sin modificar el archivo .semver


protected **RoboBase::nextVersion**(string $what) : string


|Parameters: | | |
| --- | --- | --- |
|string |$what |  |

---


### updateVersion
Actualiza el archivo .semver


protected **RoboBase::updateVersion**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $version) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$version |  |

---


### prepareTag
Prepara un release | hotfix antes de ser finalizado
 - actualiza la documentación
 - actualiza el archivo changelog
 - actualiza el archivo .semver


protected **RoboBase::prepareTag**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $version) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$version |  |

---


### getReleaseVersion
Devuelve la versión de la release actual


protected **RoboBase::getReleaseVersion**() : string



---


### getHotfixVersion
Devuelve la versión del hotfix actual


protected **RoboBase::getHotfixVersion**() : string



---


### initQa
Inicializa phpqa


protected **RoboBase::initQa**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initSami
Inicializa sami


protected **RoboBase::initSami**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initCi
Inicializa la configuración de ci (travis y scrutinizer)


protected **RoboBase::initCi**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initComposer
Inicializa composer con las dependencias minimas


protected **RoboBase::initComposer**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### composerUpdate
Actualiza las dependencias de composer


protected **RoboBase::composerUpdate**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initBehat
Inicializa Behat


protected **RoboBase::initBehat**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initPhpSpec
Inicializa phpspec


protected **RoboBase::initPhpSpec**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initProject
Inicializa los archivos con meta información sobre el proyecto


protected **RoboBase::initProject**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initGit
Inicializa git


protected **RoboBase::initGit**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### initHooks
Inicializa los hooks de git


protected **RoboBase::initHooks**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### getDevPackages
Devuelve la lista de dependencias para dev


abstract **RoboBase::getDevPackages**() : array



---


### getPackages
Devuelve la lista de dependencias


abstract **RoboBase::getPackages**() : array



---


### fixQuality
Soluciona los errores de formato que puedan arreglarse automáticamente


protected **RoboBase::fixQuality**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $dir = &#039;src&#039;) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$dir |  |

---


### checkQuality
Comprueba la calidad del código


protected **RoboBase::checkQuality**([CollectionBuilder](../../CollectionBuilder.md) $collection, string $dir = &#039;src&#039;) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |
|string |$dir |  |

---


### runAllTests
Ejecuta todos los tests


protected **RoboBase::runAllTests**([CollectionBuilder](../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../CollectionBuilder.md) |$collection |  |

---


### __construct
RoboBase constructor.


**RoboBase::__construct**() : 



---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                