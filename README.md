# Shopware app infrastructure

A Shopware app infrastructure based on Symfony and NodeJs.


## Setup

### Webserver
Setup your webserver to host this website on `http://localhost:8889`.
Example caddy configuration:

```shell
http://localhost:8889 {
  root * /Users/xyz/www/app-server/public
  php_fastcgi 127.0.0.1:9000
  file_server
  encode zstd gzip

  log {
    output file /var/log/caddy/access.log
  }

  @static {
    path_regexp \.(ico|css|js|gif|jpg|jpeg|png|svg|woff|woff2)$
  }
  header @static Cache-Control max-age=31536000
}
```

### Database
1. Check the database URL in the `.env` file and change it to match your requirements.
2. Run `bin/console doctrine:database:drop --force && bin/console doctrine:database:create && bin/console doctrine:migrations:migrate`

### Install the app
1. Copy the `manifest.xml` into `<shopware6root>/custom/apps/TestApp`.
2. Run `bin/console app:install TestApp`
3. Run `bin/console app:activate TestApp`
