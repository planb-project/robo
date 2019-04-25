
                                                                                                                                            
    
# InitProject


> métodos para inicializar las distintas herramientas
>
> 








## Methods

### initQa
Inicializa phpqa


protected **InitProject::initQa**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initSami
Inicializa sami


protected **InitProject::initSami**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initCi
Inicializa la configuración de ci (travis y scrutinizer)


protected **InitProject::initCi**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initComposer
Inicializa composer con las dependencias minimas


protected **InitProject::initComposer**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### composerUpdate
Actualiza las dependencias de composer


protected **InitProject::composerUpdate**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initBehat
Inicializa Behat


protected **InitProject::initBehat**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initPhpSpec
Inicializa phpspec


protected **InitProject::initPhpSpec**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initProject
Inicializa los archivos con meta información sobre el proyecto


protected **InitProject::initProject**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initMetadata
Inicializa los archivos con meta información sobre el proyecto


protected **InitProject::initMetadata**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initGit
Inicializa git


protected **InitProject::initGit**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### initHooks
Inicializa los hooks de git


protected **InitProject::initHooks**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


### getDevPackages
Devuelve la lista de dependencias para dev


abstract **InitProject::getDevPackages**() : array



---


### getPackages
Devuelve la lista de dependencias


abstract **InitProject::getPackages**() : array



---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                