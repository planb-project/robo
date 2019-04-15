
                                                                                                                                            
    
# Boilerplate


> Tarea para crear archivos y directorios
>
> 








## Methods

### __construct
Boilerplate constructor.


**Boilerplate::__construct**([PathManager](../../../PathManager.md) $pathManager, [ContextManager](../../../ContextManager.md) $contextManager) : 


|Parameters: | | |
| --- | --- | --- |
|[PathManager](../../../PathManager.md) |$pathManager |  |
|[ContextManager](../../../ContextManager.md) |$contextManager |  |

---


### progressIndicatorSteps
Devuelve el número de pasos


**Boilerplate::progressIndicatorSteps**() : int|void



---


### file
Crea un archivo a partir de una template


**Boilerplate::file**(string $template, string $filename, bool $force = false) : [Boilerplate](../../../Boilerplate.md)


|Parameters: | | |
| --- | --- | --- |
|string |$template |  |
|string |$filename |  |
|bool |$force |  |

---


### dir
Crea un directorio


**Boilerplate::dir**(string $dirname) : [Boilerplate](../../../Boilerplate.md)


|Parameters: | | |
| --- | --- | --- |
|string |$dirname |  |

---


### run
Ejecuta la tarea


**Boilerplate::run**() : [Result](../../../Result.md)



---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                