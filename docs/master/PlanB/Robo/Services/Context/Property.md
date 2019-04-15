
                                                                                                                                            
    
# Property


> Clase base para propiedades de composer.json.
>
> 








## Methods

### make
Crea una nueva instancia de esta propiedad


static **Property::make**() : [Property](../../../../Property.md)



---


### getPath
Devuelve el path de la propiedad en el archivo composer.json


abstract **Property::getPath**() : string



---


### getPrompt
Devuelve el prompt de la propiedad


abstract **Property::getPrompt**() : string



---


### markAsInvalid
Agrega un mensaje de advertencia al prompt


**Property::markAsInvalid**(string|null $message) : [Property](../../../../Property.md)


|Parameters: | | |
| --- | --- | --- |
|string|null |$message |  |

---


### isValid
Indica si el valor de la propiedad es valido


**Property::isValid**() : bool



---


### getDefault
Devuelve el valor por defecto


**Property::getDefault**(array $context) : string|null


|Parameters: | | |
| --- | --- | --- |
|array |$context |  |

---


### getWarningMessage
Devuelve el mensaje de advertencia


**Property::getWarningMessage**() : string|null



---


### normalize
Normaliza un valor


**Property::normalize**(string $value) : string|null


|Parameters: | | |
| --- | --- | --- |
|string |$value |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                