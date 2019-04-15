# planb/robo

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

custom cli task manager based on robo

## Install

Via Composer

``` bash
# vamos al directorio de trabajo
$ cd /path/to/planb-project/robo

# clonamos el repositorio
$ git clone git@github.com:planb-project/robo.git .

# Creamos la imagen de docker
$ docker build --rm  -t  planb/robo .
```

## Usage
Para usar la imagen docker que acabamos de crear como sin fuera un comando, creamos el siguiente script en **```/usr/local/bin/planb```**

```bash
$ chmod +x /usr/local/bin/planb
```


``` bash
 #!/bin/bash
 
 USE_TTY=""
 
 tty -s
 if [ $? -eq 0 ]
 then
   USE_TTY="-t"
 fi
 
 docker run -a stdin -a stdout -i ${USE_TTY}  --rm \
         --user $(id -u):$(id -g) \
         --env "USER_NAME=<Nombre del usuario>" \
         --env "USER_EMAIL=<Email >" \
         --env "GITHUB_ORGANIZATION=<Nombre de la organiación en github>" \
         --env "VENDOR=<El nombre del vendor principal>" \
         --volume "$(pwd):/app" \
         --volume "$HOME/.ssh:/home/user/.ssh" \
         --volume "$HOME/.gitconfig:/home/user/.gitconfig" \
         --volume "$COMPOSER_HOME:/home/user/.composer" \
         --volume "$COMPOSER_CACHE_DIR:/home/user/.composer/cache" \
         planb/robo:latest $@
 exit $?

```
con cuidado de asignar correctamente los valores de las variables de entorno

- USER_NAME: el nombre completo del usuario, 

como queremos que aparezca en el path **```[authors][0][name]```** del archivo composer.json
- USER_EMAIL: el correo electrónico

como queremos que aparezca en el path **```[authors][0][email]```** del archivo composer.json

- GITHUB_ORGANIZATION: El nombre de usuario o de la organiaación en github, como aqui:
 
 > https://github.com/**<github_organization>**/**repo-name**
    
- VENDOR: El nombre del vendor, o namespace principal del proyecto. 

Por ejemplo si el apartado **```[autoload]```** es algo asi:

```json
     "autoload": {
        "psr-4": {
            "PlanB\\Robo\\": "src/Robo/"
        }
    }
```

el vendor es **```PlanB```**


### Ejemplo:
Para proyectos propios sería algo asi:

```bash
#!/bin/bash

USE_TTY=""

tty -s
if [ $? -eq 0 ]
then
  USE_TTY="-t"
fi

docker run -a stdin -a stdout -i ${USE_TTY}  --rm \
        --user $(id -u):$(id -g) \
        --env "USER_NAME=Jose Manuel Pantoja" \
        --env "USER_EMAIL=jmpantoja@gmail.com" \
        --env "GITHUB_ORGANIZATION=planb-project" \
        --env "VENDOR=PlanB" \
        --volume "$(pwd):/app" \
        --volume "$HOME/.ssh:/home/user/.ssh" \
        --volume "$HOME/.gitconfig:/home/user/.gitconfig" \
        --volume "$COMPOSER_HOME:/home/user/.composer" \
        --volume "$COMPOSER_CACHE_DIR:/home/user/.composer/cache" \
        planb/robo:latest $@
exit $?
```

## Comandos
Por defecto se sumistran estos comandos:

- planb **quality:assurance**
    Ejecuta phpqa para evaluar la calidad del código. Se usa en el git-hook **``` pre-commit ```** 

- planb **qa:check**

    Ejecuta phpqa para evaluar la calidad del código, e intenta solucionar los errores de estilo  

- planb **run:tests**

    Lanza todos los tests (behat y phpspec)

- planb **feature:start** name      

    Inicia una feature

- planb **feature:finish** name

    Finaliza una feature     

- planb **release:start**

    Inicia una release

- planb **release:finish**    

    Finaliza la release despues de:
    - Actualiza el fichero ```.semver```
    - Actualiza el fichero ```CHANGELOG.md```
    - Actualiza la documentación (sami)

- planb **hotfix:start**       

    Inicia un hotfix
 
- planb **hotfix:finish**      

    Finaliza el hotfix despues de:
    - Actualiza el fichero ```.semver```
    - Actualiza el fichero ```CHANGELOG.md```
    - Actualiza la documentación (sami)
 

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ bin/behat
$ bin/phpspec
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email jmpantoja@gmail.com instead of using the issue tracker.

## Credits

- [Jose Manuel Pantoja][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/planb/robo.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/planb-project/robo/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/planb-project/robo.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/planb-project/robo.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/planb/robo.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/planb/robo
[link-travis]: https://travis-ci.org/planb-project/robo
[link-scrutinizer]: https://scrutinizer-ci.com/g/planb-project/robo/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/planb-project/robo
[link-downloads]: https://packagist.org/packages/planb/robo
[link-author]: https://github.com/planb-project/
[link-contributors]: ../../contributors
