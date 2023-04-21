{ pkgs, lib, config, ... }:

{
  languages.javascript = {
    enable = lib.mkDefault true;
    package = lib.mkDefault pkgs.nodejs-19_x;
  };

  languages.php = {
    enable = lib.mkDefault true;
    version = lib.mkDefault "8.1";
    # extensions = [ "grpc" ];

    ini = ''
      memory_limit = 2G
      realpath_cache_ttl = 3600
      session.gc_probability = 0
      display_errors = On
      error_reporting = E_ALL
      assert.active = 0
      opcache.memory_consumption = 256M
      opcache.interned_strings_buffer = 20
      zend.assertions = 0
      short_open_tag = 0
      zend.detect_unicode = 0
      realpath_cache_ttl = 3600
    '';

    fpm.pools.web = lib.mkDefault {
      settings = {
        "clear_env" = "no";
        "pm" = "dynamic";
        "pm.max_children" = 10;
        "pm.start_servers" = 2;
        "pm.min_spare_servers" = 1;
        "pm.max_spare_servers" = 10;
      };
    };
  };

  services.caddy = {
    enable = lib.mkDefault true;

    virtualHosts.":8889" = lib.mkDefault {
      extraConfig = lib.mkDefault ''
        @default {
          not path /theme/* /media/* /thumbnail/* /bundles/* /css/* /fonts/* /js/* /sitemap/*
        }

        root * public
        php_fastcgi @default unix/${config.languages.php.fpm.pools.web.socket} {
            trusted_proxies private_ranges
        }
        file_server
      '';
    };
  };

  services.mysql = {
    enable = true;
    initialDatabases = lib.mkDefault [{ name = "app"; }];
    ensureUsers = lib.mkDefault [
      {
        name = "app";
        password = "app";
        ensurePermissions = {
          "app.*" = "ALL PRIVILEGES";
        };
      }
    ];
    settings = {
      mysqld = {
        port = 3360;
        log_bin_trust_function_creators = 1;
      };
    };
  };

  env.APP_URL = lib.mkDefault "http://localhost:8889";
  env.APP_ENV = lib.mkDefault "dev";
  env.APP_DEBUG = lib.mkDefault "true";
  env.DATABASE_URL = lib.mkDefault "mysql://root@localhost:3360/app";
}
