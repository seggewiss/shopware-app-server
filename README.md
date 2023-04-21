# Shopware app infrastructure

A Shopware app infrastructure based on Symfony and NodeJs.


## Setup

The project contains a [devenv](http://devenv.sh) setup.
The ports are adjusted to not conflict with Shopwares devenv setup.

MySQL: 3360
Caddy: 8889

1. Run `direnv allow`
2. Run `composer install`
3. Run `php bin/console doctrine:migrations:migrate`
