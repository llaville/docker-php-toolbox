<!-- markdownlint-disable MD013 -->
# Build Dockerfiles

For all builds we suggest passing the `--build-version` (`-B`) option to choose suffix of your generated Dockerfile.

**TIP** Even if argument is free, we suggest using a build version that allow to identify quickly
contents of Dockerfile generated.

In each following commands, replace `<php_version>` by either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1

## Base images

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile -B 7422 7.4
```

Or with specialized dockerfile for PHP 5.6 or PHP 7.0:

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile-56 -B 5640 5.6
bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile-70 -B 7033 7.0
```

## Mods images

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/mods/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/mods/Dockerfile -B 8009 8.0
```

## Prod images

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/prod/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/prod/Dockerfile -B 8100 8.1
```

## Work images

By default, tools are installed in the `/usr/local/bin` directory.
To perform installation in another location, pass the `--target-dir` option.

To limit some tools to the generated Dockerfile, multiple `--tag` options can be passed.

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/work/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:dockerfile -f ./Dockerfiles/work/Dockerfile -B 7329 --target-dir /usr/bin --tag composer --tag tig 7.3
```
