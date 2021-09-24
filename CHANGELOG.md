<!-- markdownlint-disable MD013 MD024 -->
# Changelog

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/),
using the [Keep a CHANGELOG](http://keepachangelog.com) principles.

## [Unreleased]

### Fixed

- [build-version option is now insensitive and may contain any character](https://github.com/llaville/docker-php-toolbox/commit/544a7998ca3db6cc9ff6f7167c6d8fb894de2108)

### Removed

- drop support of `uopz` extension (too much trouble (segmentation fault) with others extensions)

## [1.0.0-beta.1] - 2021-09-09

### Added

#### Tools

- [support to phpmnd](https://github.com/llaville/docker-php-toolbox/commit/25d71938a408d9cb7291b6176e1b6278d2cf243c)
- [support to httpie](https://github.com/llaville/docker-php-toolbox/commit/5d62927793d0289ee2188535df4fd9efec28fab9)
- [support to http-prompt](https://github.com/llaville/docker-php-toolbox/commit/cd3f67b8d365d48d9bbe32456701d805fb4fe785)
- [support to yarn](https://github.com/llaville/docker-php-toolbox/commit/6b72a1841f72677b5e8b8cb848dccd3c594be833)

### Fixed

- file download url of `mhsendmail` tool

## [1.0.0-alpha.3] - 2021-08-30

Third prototype version with following contents (+9 tools):
[new ROADMAP](https://github.com/llaville/docker-php-toolbox/blob/c4707a0ec259b856445c89fb5404efb16275a624/ROADMAP.md)

The next release will be the first beta (beta.1), planned for 9 September 2021.

### Added

- new specialized command (`git-install`) to install source code from a GIT repository
- new specialized command (`pip-install`) to install pip (python) package
- [a79031d](https://github.com/llaville/docker-php-toolbox/commit/a79031d99ba29987335e7aa528a994bae92f06c6)
: PHP_CodeSniffer custom standard
- [fbdf1b8](https://github.com/llaville/docker-php-toolbox/commit/fbdf1b8131c794423b3166d1bbbc48f3c2dd1025)
: `exclude-tag` option and new class `Bartlett\PHPToolbox\Collection\Filter` to filter extensions and tools more easily
- [Mega-Linter](https://github.com/nvuillam/mega-linter) support as QA tool to avoid technical debt

#### Tools

- [support to cachetool](https://github.com/llaville/docker-php-toolbox/commit/0e610c0565dc68838522bdd05222f8135e1d8d12)
- [support to nvm](https://github.com/llaville/docker-php-toolbox/commit/c4707a0ec259b856445c89fb5404efb16275a624)
- [support to phive](https://github.com/llaville/docker-php-toolbox/commit/a659bedb11b119096d22b7ca5d8278b78c56257b)
- [support to php-cs-fixer](https://github.com/llaville/docker-php-toolbox/commit/bf1f35529f0cf8490864e421ea805e9371d9d7cb)
- [support to phpbench](https://github.com/llaville/docker-php-toolbox/commit/bc9497f8bcf08bb402c391c6f9dcf9e61c9185f3)
- [support to phpdd](https://github.com/llaville/docker-php-toolbox/commit/916f0df46a6d6c893b08b29682e9cfabe916095c)
- [support to phpdoc](https://github.com/llaville/docker-php-toolbox/commit/9bfa83d472182c83b3f54d6eeda03bd169a235f5)
- [support to psalm](https://github.com/llaville/docker-php-toolbox/commit/6476c7d863ae59aedd743a15aa16305c754eb074)
- [support to yamllint](https://github.com/llaville/docker-php-toolbox/commit/320aec8ea05bf79e7aaf9ee6d77a513266ec4dbf)

### Changed

- [cf22cf8](https://github.com/llaville/docker-php-toolbox/commit/cf22cf805c953b626e685cd65d26af3f3df50d33) : auto tagging by name each extension and tool in resources path
- [429a524](https://github.com/llaville/docker-php-toolbox/commit/429a524a80b6f6b9197cdad51df84ba9abfac5a0) : specialized `sh` command is replaced by `shell` command
- Dockerfile `Dockerfiles/base/Dockerfile-81` support now PHP 8.1.0beta3
- Dockerfiles `Dockerfiles/base/Dockerfile*` are based on buster (Debian 10)
because recent distribution with bullseye (Debian 11) does not support yet a microsoft odbc driver

## [1.0.0alpha2] - 2021-08-14

Second prototype version with following contents (+40 extensions, +5 tools):
[new ROADMAP](https://github.com/llaville/docker-php-toolbox/blob/3d4408aab3ff0af7e6f9b9d0fce7b1261d5ae103/ROADMAP.md)

### Added

- `CHANGELOG.md` file to follow changes to this project
- [c5cb09b](https://github.com/llaville/docker-php-toolbox/commit/c5cb09b87455c0c36644fa11afd2703375d1f2d6)
: Display timing and memory usage information with `profile` option on `build:image` command

#### Extensions

- [support to bcmath extension](https://github.com/llaville/docker-php-toolbox/commit/c814392e5705b1752bd4de0ee144ed30948a3942)
- [support to bz2 extension](https://github.com/llaville/docker-php-toolbox/commit/0c39ea2c42145769f8c98530306424827fcae963)
- [support to calendar extension](https://github.com/llaville/docker-php-toolbox/commit/0dda6731d51bdee701abdc1cb1c728a500475797)
- [support to dba extension](https://github.com/llaville/docker-php-toolbox/commit/3ca4ff3fcdd7e530683f99e0ea70abdbf6377454)
- [support to enchant extension](https://github.com/llaville/docker-php-toolbox/commit/08cc72fb842793545b361393b790fc807ef4a7f1)
- [support to exif extension](https://github.com/llaville/docker-php-toolbox/commit/feb2f56f14ef92ab80df98ac1a1672b9903b9886)
- [support to gd extension](https://github.com/llaville/docker-php-toolbox/commit/ccdb47f2bc93894533ed19568766fd5d8297d73f)
- [support to gettext extension](https://github.com/llaville/docker-php-toolbox/commit/15681c13f8ec7624d7eae2e1034f1fac48bd3271)
- [support to gmp extension](https://github.com/llaville/docker-php-toolbox/commit/5bcabe41013aa521e977cadb7d7ca0017c2357bd)
- [support to imap extension](https://github.com/llaville/docker-php-toolbox/commit/11af2ddfa32428cb802a18456aed989d02913977)
- [support to interbase extension](https://github.com/llaville/docker-php-toolbox/commit/d069ee6ec39b79c1f55802f32d10657d61c6a549)
- [support to intl extension](https://github.com/llaville/docker-php-toolbox/commit/a28bdcc433721644e03ccc3e2539084a8387be44)
- [support to ioncube loader extension](https://github.com/llaville/docker-php-toolbox/commit/3cce17a027e756eff2f8112d2c62405e93a13a46)
- [support to ldap extension](https://github.com/llaville/docker-php-toolbox/commit/a7e29aea923f1d10997dda9a35af9c1df47e1beb)
- [support to mysql extension](https://github.com/llaville/docker-php-toolbox/commit/dd62b7b4bad860485f948f50e0191c983f900dcb)
- [support to mysqli extension](https://github.com/llaville/docker-php-toolbox/commit/6b0951838825a4f9aaf96c47e0e907a88f2d0957)
- [support to opcache extension](https://github.com/llaville/docker-php-toolbox/commit/fe201b07e0d5e0a3a7dfa00795ed8e2ccc831e14)
- [support to oci8 extension](https://github.com/llaville/docker-php-toolbox/commit/b0cb3b589ec018c5e5aee29dc79ea2dd27fbd495)
- [support to pcntl extension](https://github.com/llaville/docker-php-toolbox/commit/749dc055c6a12c25924f70f1f24d9bbea6a2e58d)
- [support to pdo_dblib extension](https://github.com/llaville/docker-php-toolbox/commit/c94d04dd07f6d040ab42ced9a79d605f084391b1)
- [support to pdo_firebird extension](https://github.com/llaville/docker-php-toolbox/commit/89798a4096a8d3fe3b14142af93710232dbdc855)
- [support to pdo_mysql extension](https://github.com/llaville/docker-php-toolbox/commit/2ade6d6967ee730d66216376bd17a4a542c3345f)
- [support to pdo_oci extension](https://github.com/llaville/docker-php-toolbox/commit/8c9c7041fa4c9f2424ddc6a751321b80f00cb0ee)
- [support to pdo_odbc extension](https://github.com/llaville/docker-php-toolbox/commit/6eb20ce38b9b0517b14e7b354d187d9a72973a62)
- [support to pdo_pgsql extension](https://github.com/llaville/docker-php-toolbox/commit/4186c068f38b944d987e28e5c47172b08acc0f9f)
- [support to pdo_sqlsrv extension](https://github.com/llaville/docker-php-toolbox/commit/2b8c260577cd2b8cb039039610e3e0a1bcaad688)
- [support to pgsql extension](https://github.com/llaville/docker-php-toolbox/commit/37c4322af7b616f5c57989967df97fb3db78af7a)
- [support to pspell extension](https://github.com/llaville/docker-php-toolbox/commit/7647a0c51a6b6a0f6d893ee964a67a2688f14e28)
- [support to shmop extension](https://github.com/llaville/docker-php-toolbox/commit/4fd57819890bdff8176d2cdc5a2aef25114cbe67)
- [support to snmp extension](https://github.com/llaville/docker-php-toolbox/commit/89337e5003daba0a764f9dc7005170d7c4d82881)
- [support to soap extension](https://github.com/llaville/docker-php-toolbox/commit/23ca24007d3d400c6393a55b563b458c4400f34f)
- [support to sockets extension](https://github.com/llaville/docker-php-toolbox/commit/646f6679ed10540cc17be3536ce27d17f14db3fd)
- [support to sqlsrv extension](https://github.com/llaville/docker-php-toolbox/commit/21493a320c2ee8babe45b5ea8158ff81980eb2e3)
- [support to swoole extension](https://github.com/llaville/docker-php-toolbox/commit/01bff22e85001f6a4db6b03ec63bddfe3e4a7a50)
- [support to sysvmsg extension](https://github.com/llaville/docker-php-toolbox/commit/f132a7d878393c6518885600c3d007ba941cece8)
- [support to sysvsem extension](https://github.com/llaville/docker-php-toolbox/commit/7a0b9c5f843e87e821c74d901f91f9e3fcfa7567)
- [support to sysvshm extension](https://github.com/llaville/docker-php-toolbox/commit/941512599af71b58ed94a72f67ba32d82333174b)
- [support to tidy extension](https://github.com/llaville/docker-php-toolbox/commit/4cb31324cb640b8d3900525790dabfc9125cf0fa)
- [support to xsl extension](https://github.com/llaville/docker-php-toolbox/commit/c2aa2f87b7016300ae98486dc7b0c64abd6d0a9f)
- [support to yar extension](https://github.com/llaville/docker-php-toolbox/commit/c9a2220f9cb7fcad5e4c5fecd8aaaa8d2f14a66c)

#### Tools

- [support to deployer](https://github.com/llaville/docker-php-toolbox/commit/83e2e8810766d7b0822057906350d38f83b5f165)
- [support to PHP_CodeSniffer](https://github.com/llaville/docker-php-toolbox/commit/53e532e1f1d89cc42380662e5d131e0a1d5ebd85)
- [support to phpcbf](https://github.com/llaville/docker-php-toolbox/commit/5ce65db98e97e1b327ea070e019941cb19373f7d)
- [support to phpstan](https://github.com/llaville/docker-php-toolbox/commit/0bb7ac4f8e8112372d94bebdf474777e54e0063a)
- [support to phpunit 6.x versions](https://github.com/llaville/docker-php-toolbox/commit/5b1c19fd4d1bfbca680872dc9ccb7b2bf5a701f6)
- [support to phpunit 5.x versions](https://github.com/llaville/docker-php-toolbox/commit/295691407291e9567a7bdeea0e80fc0ce0fcfb7a)
- [support to phpunit 4.x versions](https://github.com/llaville/docker-php-toolbox/commit/5593304209bf493e16b5edea7e0067f5eebd6780)

### Changed

- [33967d7](https://github.com/llaville/docker-php-toolbox/commit/33967d777f0cabe9ea4859f17528d07ca411f253)
: Make Dockerfile process is now optimized (quick build) to avoid invalidate cache when not necessary (when `no-cache` option is not specified)

## [1.0.0alpha1] - 2021-08-07

### Added

First prototype version with following contents:
[ROADMAP](https://github.com/llaville/docker-php-toolbox/blob/e3159c67983107b525270f4770ef8483dd065312/ROADMAP.md)

[unreleased]: https://github.com/llaville/docker-php-toolbox/compare/1.0.0alpha2...HEAD
[1.0.0alpha2]: https://github.com/llaville/docker-php-toolbox/compare/1.0.0alpha1...1.0.0alpha2
[1.0.0alpha1]: https://github.com/llaville/docker-php-toolbox/releases/tag/1.0.0alpha1
