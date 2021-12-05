<!-- markdownlint-disable MD013 -->
# Build Images

Proceed with the same build identification as used in the `build:dockerfile` command, passing the `--build-version` (`-B`) option.

**NOTE** If you want to see real-time docker long process running, don't forget to activate verbose level 3 (`-vvv`) on each command.

In each following commands, replace `<php_version>` by either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1

## Base images

```shell
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile -B <build_version> <php_version>
```

For example:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile -B 7422 -vvv 7.4
```

Or with specialized dockerfile:

```shell
bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile-81 -B 8100 -vvv 8.1
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
