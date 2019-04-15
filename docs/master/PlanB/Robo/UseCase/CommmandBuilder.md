
                                                                                                                                            
    
# CommmandBuilder


> Crea objetos Command
>
> 








## Methods

### __construct
CommmandBuilder constructor.


**CommmandBuilder::__construct**([PathManager](../../../PathManager.md) $pathManager, [Context](../../../Context.md) $context) : 


|Parameters: | | |
| --- | --- | --- |
|[PathManager](../../../PathManager.md) |$pathManager |  |
|[Context](../../../Context.md) |$context |  |

---


### buildCreateFileCommand
Crea un objeto CreateFileCommmand


**CommmandBuilder::buildCreateFileCommand**(string $template, string $filename, bool $force) : [CreateFileCommmand](../../../CreateFileCommmand.md)


|Parameters: | | |
| --- | --- | --- |
|string |$template |  |
|string |$filename |  |
|bool |$force |  |

---


### buildCreateDirectoryCommand
Crea un objeto CreateDirectoryCommmand


**CommmandBuilder::buildCreateDirectoryCommand**(string $dirname) : [CreateDirectoryCommmand](../../../CreateDirectoryCommmand.md)


|Parameters: | | |
| --- | --- | --- |
|string |$dirname |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                