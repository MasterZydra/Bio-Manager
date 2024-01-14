# Bio-Manager

This web application is a kind of ERP system specially adapted to the requirements for the management of certified organic plots of land. It should be easy to use and simplify administrative work.

The purpose of the project is also to get a better understanding of the concepts and systems working in the background e.g. in the Laravel framework. That is why everything is self written and very similar to Laravel. The concepts, naming conventions and schemes etc. are copied from Laravel while the implementation of the underlying code is written by myself. 

This project works with a self written framework.  
It contains:
- an autoloader
- a router
- a testing framework
- internationalization support
- rendering views and components
- extendable CLI e.g. for running tests, creating controllers, models, etc.
- a database migration system
- a database model with magic getter and setter functions

## Links
- [Documentation](doc/README.md)
  - [Framework documentation](doc/Framework.md)

## Getting started
One way to run the application is the usage of docker.

### Requirements
The application uses a MariaDB to store the data.
You must run a MariaDB server that the container can access.
On this server a database with the name `bioman` must exist (Can be changed in .env or via environment variable: `DB_DATABASE`).

### Download the docker image
You can use the latest version: (This is not recommended as it might by unstable)
```bash
docker pull ghcr.io/masterzydra/bio-manager:latest
```

Or use a specific version:
```bash
docker pull ghcr.io/masterzydra/bio-manager:v2.0.0
```

You can find all versions [here](https://github.com/MasterZydra/Bio-Manager/pkgs/container/bio-manager/versions).

### Run the docker image
Because the docker image `serversideup/php:8.X-fpm-apache` is used as base image the SSL_MODE can be changed ([more details](https://serversideup.net/open-source/docker-php/docs/guide/customizing-the-image#production-ssl-configurations)).
The default values from [`.env.example`](.env.example) can be overwritten by setting the new value as environment variable.

```bash
docker run --env SSL_MODE=off --env DB_USERNAME=root --env DB_PASSWORD=toor ghcr.io/masterzydra/bio-manager:latest
```

### Default credentials
While the docker container is starting, it executes the `migrate` command.
It creates a user account with the username `admin` and the password `mySecurePassword1!`.
It is recommended to change the password or delete the user after a new one is created.

## Development
The development can be done with just Visual Studio Code and Docker.

Start the MariaDB database:
```bash
docker run -d --network host --env MARIADB_USER=user --env MARIADB_PASSWORD=secret --env MARIADB_DATABASE=bioman --env MARIADB_ROOT_PASSWORD=secret --name mariadb mariadb:latest
```

Restart the MariaDB container e.g. after system restart:
```bash
docker restart mariadb
```

Run the application:
```bash
docker run --rm -d --network host -e PUID=$UID -e PGID=$UID --env SSL_MODE=off --name bioman -v $(pwd):/var/www/html:z ghcr.io/masterzydra/bio-manager:latest
```

Execute the bioman CLI:
```bash
docker exec -it bioman php bioman
```
