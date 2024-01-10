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

## Development
The development can be done with just Visual Studio Code and Docker.

Start the MariaDB database:  
`> docker run -d --network host --env MARIADB_USER=user --env MARIADB_PASSWORD=secret --env MARIADB_DATABASE=bioman --env MARIADB_ROOT_PASSWORD=secret --name mariadb mariadb:latest`

Restart the MariaDB container e.g. after system restart:  
`> docker restart mariadb`

Run the application:  
`> docker run --rm -d --network host -e PUID=$UID -e PGID=$UID -e SSL_MODE=off --name bioman -v $(pwd):/var/www/html:z serversideup/php:8.2-fpm-apache`

Execute the bioman CLI:  
`> docker exec -it bioman php bioman` 
