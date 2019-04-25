
                                                                                                                                            
    
# QualityAssurance


> Métodos relacionados con el control de calidad
>
> 








## Methods

### fixQuality
Soluciona los errores de formato que puedan arreglarse automáticamente


protected **QualityAssurance::fixQuality**([CollectionBuilder](../../../CollectionBuilder.md) $collection, string $dir = &#039;src&#039;) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |
|string |$dir |  |

---


### checkQuality
Comprueba la calidad del código


protected **QualityAssurance::checkQuality**([CollectionBuilder](../../../CollectionBuilder.md) $collection, string $dir = &#039;src&#039;) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |
|string |$dir |  |

---


### getQualityTools
Devuelve la lista de herramietas de qa que vamos a aplicar


abstract **QualityAssurance::getQualityTools**() : array



---


### runAllTests
Ejecuta todos los tests


protected **QualityAssurance::runAllTests**([CollectionBuilder](../../../CollectionBuilder.md) $collection) : void


|Parameters: | | |
| --- | --- | --- |
|[CollectionBuilder](../../../CollectionBuilder.md) |$collection |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                