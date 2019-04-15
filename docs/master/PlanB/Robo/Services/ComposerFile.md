
                                                                                                                                            
    
# ComposerFile


> Clase que nos permite leer y escribir valores de composer.json.
>
> 








## Methods

### __construct
ComposerInfo constructor.


**ComposerFile::__construct**(string $composerPath) : 


|Parameters: | | |
| --- | --- | --- |
|string |$composerPath |  |

---


### get
Devuelve el valor que corresponde a un path.


**ComposerFile::get**(string $path) : mixed


|Parameters: | | |
| --- | --- | --- |
|string |$path |  |

---


### addAutoloadPsr4
Añade una entrada al apartado autoload/psr-4


**ComposerFile::addAutoloadPsr4**(string $namespace, string $dirname) : [ComposerFile](../../../ComposerFile.md)


|Parameters: | | |
| --- | --- | --- |
|string |$namespace |  |
|string |$dirname |  |

---


### set
Asigna un valor a un path.


**ComposerFile::set**(string $path, mixed $value) : [ComposerFile](../../../ComposerFile.md)


|Parameters: | | |
| --- | --- | --- |
|string |$path |  |
|mixed |$value |  |

---


### has
Indica si un path tiene valor.


**ComposerFile::has**(string $path) : bool


|Parameters: | | |
| --- | --- | --- |
|string |$path |  |

---


### save
Guarda los cambios si los hay.


**ComposerFile::save**() : void



---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                