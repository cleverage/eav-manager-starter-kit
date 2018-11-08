CleverAge/EAVManager Starter Kit
================================

The main documentation is located here: [CleverAge/EAVManager](https://github.com/cleverage/eav-manager)

## Requirements
### For GNU / Linux

* make
* Docker (latest version)
* Docker-compose (latest version)

#### BEWARE of docker-compose on GNU/Linux

Docker-compose isn't automatically updated on your GNU/linux distribution : 
sometimes, you miss some useful update. 

### For MacOS X

* Docker-for-mac (latest version)
* Docker-Sync (version 0.5.7 - due to the lack of performance of shared volumes on Docker-for-Mac)
* make

## Installation

You will need make, docker and docker-compose installed on your machine.

````bash
$ make install
````

If this setup conflicts with open ports on your system, simply edit your ````docker/.env```` file.

From there you will be in a shell inside you main container

### Accessing the application

The Nginx server will answer to any domain so you can either go to [http://127.0.0.1](http://127.0.0.1) or to any
domain matching this IP.

All the emails sent by the application are caught by mailcatcher: [http://127.0.0.1:1080](http://127.0.0.1:1080)

### Managing docker containers

Starting your containers

````bash
$ make start
````

Stoping your containers

````bash
$ make stop
````

### About Docker

#### Overriding docker-compose configuration for you development environment

Because every developer does what he wants on his machine, you can add a **docker-compose.override.yml** 
to override the docker-compose native configuration. This **docker-compose.override.yml** won't be versioned by Git.

For example, it's useful to override to expose a port on your localhost :

```yaml
version: "3.4"
services:
  mysql:
    ports:
    - 3307:3306
```

#### Dockerfile.example

This dockerfile is a good example of what we can do for docker in production.

### Make help

```shell
$ make help

cc                             [symfony] brutal cache clearer (useful on macOs)
clean                          [project] clean your dev environnement of all artefacts (docker containers and associated volumes, vendor, docker-sync volumes)
help                           This help
install                        Run Docker // Install application
logs                           [docker] show docker logs (you can specify a container with C='fpm')
sf-doctrine-create             [doctrine] database create
sf                             [symfony] entrypoint for a Symfony Command (exemple: make sf CMD=cache:clear)
shell                          [shell] connection to php container php
start                          Start docker-compose (with Docker-Sync if you work on Mac Os X)
stop                           Stop docker-compose (with Docker-Sync if you work on Mac Os X)
```

## Editing your model

All the configuration is in ````app/config````.
