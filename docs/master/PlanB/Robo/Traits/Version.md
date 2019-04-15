
                                                                                                                                            
    
# Version


> Métodos relacionados con el control de versiones
>
> 








## Methods

### getGitManager
Devuelve un objeto GitManager


abstract **Version::getGitManager**() : [GitManager](../../../GitManager.md)



---


### nextVersion
Devuelve el la próxima versión, sin modificar el archivo .semver


protected **Version::nextVersion**(string $what) : string


|Parameters: | | |
| --- | --- | --- |
|string |$what |  |

---


### updateVersion
Actualiza el archivo .semver


protected **Version::updateVersion**([CollectionBuilder](../../../CollectionBuilder.md) $collection, string $version) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |
|string |$version |  |

---


### prepareTag
Prepara un release | hotfix antes de ser finalizado
 - actualiza la documentación
 - actualiza el archivo changelog
 - actualiza el archivo .semver


protected **Version::prepareTag**([CollectionBuilder](../../../CollectionBuilder.md) $collection, string $version) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |
|string |$version |  |

---


### getReleaseVersion
Devuelve la versión de la release actual


protected **Version::getReleaseVersion**() : string



---


### getHotfixVersion
Devuelve la versión del hotfix actual


protected **Version::getHotfixVersion**() : string



---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                