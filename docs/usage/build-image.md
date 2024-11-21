<!-- markdownlint-disable MD013 -->
# Build Images

Proceed with the same build identification as used in the `build:dockerfile` command, passing the `--build-version` (`-B`) option.

**NOTE** If you want to see real-time docker long process running, don't forget to activate verbose level 3 (`-vvv`) on each command.

In each following commands, replace `<php_version>` by either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3 or 8.4

## Base images

```shell
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile -B 7422 -vvv 7.4
```

Or with specialized dockerfile for PHP 5.6 or PHP 7.0:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile-56 -B 5640 -vvv 5.6
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile-70 -B 7033 -vvv 7.0
```

## Mods images

```shell
bin/toolkit.php build:image -f ./Dockerfiles/mods/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/mods/Dockerfile -B 8009 8.0
```

## Prod images

```shell
bin/toolkit.php build:image -f ./Dockerfiles/prod/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/prod/Dockerfile -B 8100 8.1
```

## Work images

```shell
bin/toolkit.php build:image -f ./Dockerfiles/work/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/work/Dockerfile -B 7329 -vvv 7.3
```
