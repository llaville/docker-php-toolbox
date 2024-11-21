<!-- markdownlint-disable MD013 -->
# List available tools

```shell
bin/toolkit.php list:tools <php_version>
```

Replace `<php_version>` by either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3 or 8.4

To get list of compatible tools for a PHP platform.

## Filter tools by tags

To limit some tools from the listing, multiple `--tag` options can be added.

For example:

```shell
bin/toolkit.php list:tools 7.4 --tag composer --tag phpunit
```

that prints following output:

```text
List available tools for PHP 7.4
================================

 ------------------- ------------------------------------------ -----------------------------------------------------
  Name                Description                                Website
 ------------------- ------------------------------------------ -----------------------------------------------------
  asciinema           Terminal session recorder                  https://github.com/asciinema/asciinema
  cachetool 6         CLI application and library to manage      https://github.com/gordalina/cachetool
                      apc and opcache (6.x version)
  cachetool 7         CLI application and library to manage      https://github.com/gordalina/cachetool
                      apc and opcache (7.x version)
  composer            Dependency Manager for PHP (2.x version)   https://github.com/composer/composer
  deployer 2          A deployment tool for PHP (2.x versions)   https://github.com/deployphp/deployer
  deployer 3          A deployment tool for PHP (3.x versions)   https://github.com/deployphp/deployer
  deployer 4          A deployment tool for PHP (4.x versions)   https://github.com/deployphp/deployer
  deployer 6          A deployment tool for PHP (6.x versions)   https://github.com/deployphp/deployer
  deployer 7          A deployment tool for PHP (7.x versions)   https://github.com/deployphp/deployer
  graphviz            Graph Visualization Tools                  https://graphviz.org/
  htop                Interactive process viewer                 https://github.com/htop-dev/htop
  HTTP Prompt         An interactive command-line HTTP and API   https://github.com/httpie/http-prompt
                      testing client built on top of HTTPie
  HTTPie              A modern user-friendly command-line HTTP   https://github.com/httpie/httpie
                      client for the API era
  jq                  Command-line JSON processor                https://github.com/stedolan/jq
  Laravel Installer   The PHP Framework for Web Artisans         https://github.com/laravel/installer
  mhsendmail          sendmail for MailHog                       https://github.com/BlueBambooStudios/mhsendmail
  nvm                 Node Version Manager                       https://github.com/nvm-sh/nvm
  OpenJDK             Standard Java or Java compatible Runtime   https://openjdk.java.net/projects/jdk/
                      (headless)
  OpenJDK             OpenJDK Java runtime, using Hotspot JIT    https://openjdk.org/projects/jdk/21/
                      (headless) (JDK 21 LTS)
  OpenJDK             OpenJDK Java runtime, using Hotspot JIT    https://openjdk.java.net/projects/jdk/17
                      (headless) (JDK 17 LTS)
  OpenJDK             OpenJDK Java runtime, using Hotspot JIT    https://openjdk.java.net/projects/jdk/11
                      (headless) (JDK 11 LTS)
  phive               The PHAR Installation and Verification     https://github.com/phar-io/phive
                      Environment
  php-cs-fixer 2      PHP Coding Standards Fixer (2.x            https://github.com/FriendsOfPHP/PHP-CS-Fixer
                      versions)
  php-cs-fixer 3      PHP Coding Standards Fixer (3.x            https://github.com/FriendsOfPHP/PHP-CS-Fixer
                      versions)
  phpbench            PHP Benchmarking framework                 https://github.com/phpbench/phpbench
  phpbu 6             PHP Backup Utility (6.x version)           https://github.com/sebastianfeldmann/phpbu
  phpcbf 2            Automatically corrects coding standard     https://github.com/squizlabs/PHP_CodeSniffer
                      violations
  phpcbf 3            Automatically corrects coding standard     https://github.com/squizlabs/PHP_CodeSniffer
                      violations
  phpcs 2             PHP_CodeSniffer detects violations of a    https://github.com/squizlabs/PHP_CodeSniffer
                      defined set of coding standards
  phpcs 3             PHP_CodeSniffer detects violations of a    https://github.com/squizlabs/PHP_CodeSniffer
                      defined set of coding standards
  phpdd               Finds usage of deprecated features         https://github.com/wapmorgan/PhpDeprecationDetector
  phpdoc              Documentation Generator for PHP            https://github.com/phpdocumentor/phpdocumentor
  phpmnd              PHP Magic Number Detector                  https://github.com/povils/phpmnd
  phpstan             PHP Static Analysis Tool                   https://github.com/phpstan/phpstan
  phpunit 8           The PHP Unit Testing framework (8.x        https://github.com/sebastianbergmann/phpunit
                      version)
  phpunit 9           The PHP Unit Testing framework (9.x        https://github.com/sebastianbergmann/phpunit
                      version)
  pickle              PHP Extension installer                    https://github.com/FriendsOfPHP/pickle
  pip v2              The Python package installer (2.x          https://github.com/pypa/pip
                      version)
  pip v3              The Python package installer (3.x          https://github.com/pypa/pip
                      version)
  psalm               Finds errors in PHP applications           https://github.com/vimeo/psalm
  tig                 Text-mode interface for git                https://github.com/jonas/tig
  WordPress CLI       WP-CLI is the command-line interface for   https://github.com/wp-cli/wp-cli
                      WordPress.
  yarn                Yarn is a package manager that doubles     https://github.com/yarnpkg/berry
                      down as project manager
  yq                  Command-line YAML processor                https://github.com/mikefarah/yq
 ------------------- ------------------------------------------ -----------------------------------------------------

 ! [NOTE] 44 tools available.
```
