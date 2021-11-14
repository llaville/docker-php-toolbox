<!-- markdownlint-disable MD013 -->
# List available extensions

```shell
bin/toolkit.php list:extensions <php_version>
```

To get list of compatible extensions for a PHP platform.

For example:

```shell
bin/toolkit.php list:extensions 8.1
```

that prints following output:

```shell
List available extensions for PHP 8.1
=====================================

 -------------- -------------------------------- -------------------------------------------------------------
  Name           Description                      Website
 -------------- -------------------------------- -------------------------------------------------------------
  amqp           The amqp PHP Extension           https://pecl.php.net/package/amqp
  apcu           The apcu PHP Extension           https://pecl.php.net/package/APCu
  ast            The ast PHP Extension            https://pecl.php.net/package/ast
  bcmath         The bcmath PHP Extension         https://github.com/php/php-src/tree/master/ext/bcmath
  bz2            The bz2 PHP Extension            https://github.com/php/php-src/tree/master/ext/bz2
  calendar       The calendar PHP Extension       https://github.com/php/php-src/tree/master/ext/calendar
  dba            The dba PHP Extension            https://github.com/php/php-src/tree/master/ext/dba
  enchant        The enchant PHP Extension        https://github.com/php/php-src/tree/master/ext/enchant
  exif           The exif PHP Extension           https://github.com/php/php-src/tree/master/ext/exif
  gd             The gd PHP Extension             https://github.com/php/php-src/tree/master/ext/gd
  gettext        The gettext PHP Extension        https://github.com/php/php-src/tree/master/ext/gettext
  gmp            The gmp PHP Extension            https://github.com/php/php-src/tree/master/ext/gmp
  http           The http PHP Extension           https://pecl.php.net/package/pecl_http
  igbinary       The igbinary PHP Extension       https://pecl.php.net/package/igbinary
  imagick        The imagick PHP Extension        https://pecl.php.net/package/imagick
  imap           The imap PHP Extension           https://github.com/php/php-src/tree/master/ext/imap
  intl           The intl PHP Extension           https://github.com/php/php-src/tree/master/ext/intl
  ldap           The ldap PHP Extension           https://github.com/php/php-src/tree/master/ext/ldap
  lzf            The lzf PHP Extension            https://pecl.php.net/package/lzf
  mcrypt         The mcrypt PHP Extension         https://pecl.php.net/package/mcrypt
  memcache       The memcache PHP Extension       https://pecl.php.net/package/memcache
  memcached      The memcached PHP Extension      https://pecl.php.net/package/memcached
  msgpack        The msgpack PHP Extension        https://pecl.php.net/package/msgpack
  mysqli         The mysqli PHP Extension         https://github.com/php/php-src/tree/master/ext/mysqli
  oauth          The oauth PHP Extension          https://pecl.php.net/package/oauth
  oci8           The oci8 PHP Extension           https://pecl.php.net/package/oci8
  opcache        The opcache PHP Extension        https://github.com/php/php-src/tree/master/Zend
  pcntl          The pcntl PHP Extension          https://github.com/php/php-src/tree/master/ext/pcntl
  pdo_firebird   The pdo_firebird PHP Extension   https://github.com/php/php-src/tree/master/ext/pdo_firebird
  pdo_mysql      The pdo_mysql PHP Extension      https://github.com/php/php-src/tree/master/ext/pdo_mysql
  pdo_oci        The pdo_oci PHP Extension        https://github.com/php/php-src/tree/master/ext/pdo_oci
  pdo_odbc       The pdo_odbc PHP Extension       https://github.com/php/php-src/tree/master/ext/pdo_odbc
  pdo_pgsql      The pdo_pgsql PHP Extension      https://github.com/php/php-src/tree/master/ext/pdo_pgsql
  pdo_sqlsrv     The pdo_sqlsrv PHP Extension     https://pecl.php.net/package/pdo_sqlsrv
  pgsql          The pgsql PHP Extension          https://github.com/php/php-src/tree/master/ext/pgsql
  pspell         The pspell PHP Extension         https://github.com/php/php-src/tree/master/ext/pspell
  raphf          The raphf PHP Extension          https://pecl.php.net/package/raphf
  redis          The redis PHP Extension          https://pecl.php.net/package/redis
  shmop          The shmop PHP Extension          https://github.com/php/php-src/tree/master/ext/shmop
  snmp           The snmp PHP Extension           https://github.com/php/php-src/tree/master/ext/snmp
  soap           The soap PHP Extension           https://github.com/php/php-src/tree/master/ext/soap
  sockets        The sockets PHP Extension        https://github.com/php/php-src/tree/master/ext/sockets
  solr           The solr PHP Extension           https://pecl.php.net/package/solr
  sqlsrv         The sqlsrv PHP Extension         https://pecl.php.net/package/sqlsrv
  ssh2           The ssh2 PHP Extension           https://pecl.php.net/package/ssh2
  sysvmsg        The sysvmsg PHP Extension        https://github.com/php/php-src/tree/master/ext/sysvmsg
  sysvsem        The sysvsem PHP Extension        https://github.com/php/php-src/tree/master/ext/sysvsem
  sysvshm        The sysvshm PHP Extension        https://github.com/php/php-src/tree/master/ext/sysvshm
  tidy           The tidy PHP Extension           https://github.com/php/php-src/tree/master/ext/tidy
  uuid           The uuid PHP Extension           https://pecl.php.net/package/uuid
  vips           The vips PHP Extension           https://pecl.php.net/package/vips
  xdebug         The xdebug PHP Extension         https://pecl.php.net/package/xdebug
  xhprof         The xhprof PHP Extension         https://pecl.php.net/package/xhprof
  xmldiff        The xmldiff PHP Extension        https://pecl.php.net/package/xmldiff
  xsl            The xsl PHP Extension            https://github.com/php/php-src/tree/master/ext/xsl
  yar            The yar PHP Extension            https://pecl.php.net/package/yar
  zip            The zip PHP Extension            https://pecl.php.net/package/zip
 -------------- -------------------------------- -------------------------------------------------------------

 ! [NOTE] 57 extensions available. The pre-installed PHP extensions are excluded from this list.
```
