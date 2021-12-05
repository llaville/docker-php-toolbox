<!-- markdownlint-disable MD013 -->
# List available tools

```shell
bin/toolkit.php list:tools <php_version>
```

Replace `<php_version>` by either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1

To get list of compatible tools for a PHP platform.

## Filter tools by tags

To limit some tools from the listing, multiple `--tag` options can be added.

For example:

```shell
bin/toolkit.php list:tools 7.4 --tag composer --tag phpunit
```

that prints following output:

```shell
List available tools for PHP 7.4
================================

 ----------- ---------------------------------------------- ----------------------------------------------
  Name        Description                                    Website
 ----------- ---------------------------------------------- ----------------------------------------------
  composer    Dependency Manager for PHP                     https://github.com/composer/composer
  phpunit 8   The PHP Unit Testing framework (8.x version)   https://github.com/sebastianbergmann/phpunit
  phpunit 9   The PHP Unit Testing framework (9.x version)   https://github.com/sebastianbergmann/phpunit
 ----------- ---------------------------------------------- ----------------------------------------------

 ! [NOTE] 3 tools available.
```
