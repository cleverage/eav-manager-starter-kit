Client / Project
==================

## Dev Installation

    $ composer install
    $ app/console doctrine:database:create
    $ app/console doctrine:schema:create
    $ app/console doctrine:fixtures:load

## New remote server installation

Server stack:
    $ apt-get install nginx php5 php5-fpm mysql-server php5-cli git
    
Configure nginx and PHP-FPM

PHP stack
    $ apt-get install php5-intl php5-mysql php5-mongo

Third-party requirements:
    $ apt-get install npm
    $ npm install -g uglifyjs
    $ npm install -g uglifycss
    
As deployer user:
Validate remote git ssh key:
    $ ssh git@git.clever-age.net

MYSQL Setup:
    CREATE USER 'client'@'localhost' IDENTIFIED BY '<insert new password here>';
    GRANT ALL PRIVILEGES ON `client\_%`.* TO 'client'@'localhost';
    CREATE DATABASE client_project;

On local machine:
    $ cap deploy:setup
    $ cap deploy

On remote:
    $ app/console doctrine:schema:create
