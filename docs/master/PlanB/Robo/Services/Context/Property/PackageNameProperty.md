
                                                                                                                                            
    
# PackageNameProperty


> Propiedad package name.
>
> 




## Constants
- PATTERN




## Methods

### make
Crea una nueva instancia de esta propiedad


static **PackageNameProperty::make**() : [Property](../../../../../Property.md)



---


### getPath
Devuelve el path de la propiedad en el archivo composer.json


**PackageNameProperty::getPath**() : string



---


### getPrompt
Devuelve el prompt de la propiedad


**PackageNameProperty::getPrompt**() : string



---


### markAsInvalid
Agrega un mensaje de advertencia al prompt


**PackageNameProperty::markAsInvalid**(string|null $message) : [Property](../../../../../Property.md)


|Parameters: | | |
| --- | --- | --- |
|string|null |$message |  |

---


### isValid
Indica si el valor de la propiedad es valido


**PackageNameProperty::isValid**() : bool



---


### getDefault
Devuelve el valor por defecto


**PackageNameProperty::getDefault**(array $context) : string|null


|Parameters: | | |
| --- | --- | --- |
|array |$context |  |

---


### getWarningMessage
Devuelve el mensaje de advertencia


**PackageNameProperty::getWarningMessage**() : string|null



---


### normalize
Normaliza un valor


**PackageNameProperty::normalize**(string $value) : string|null


|Parameters: | | |
| --- | --- | --- |
|string |$value |  |

---


### configConstraintList
Configura los constraints de la propiedad


**PackageNameProperty::configConstraintList**([ConstraintList](../../../../../ConstraintList.md) $constraintList) : void


|Parameters: | | |
| --- | --- | --- |
|[ConstraintList](../../../../../ConstraintList.md) |$constraintList |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                