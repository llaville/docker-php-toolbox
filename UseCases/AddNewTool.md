<!-- markdownlint-disable MD013 -->
# How to add a new tool

## What you'll learn ?

- define a new tool in JSON format
- update your `Dockerfile` work image to install the new tool

## Audience

Developers, DevOps engineers, and Contributors with PHP/JSON (and Docker) skill.

> Steps to complete this course: 3

To follow this course, we will add the [box](https://github.com/box-project/box) project as new tool into your PHP container.

## Step 1 - define the new tool

In your favorite `resources` directory that should have at least two subdirectories (`extensions` and `tools`),
add a new JSON file (i.e: `box.json`, but you are free to use whatever you want as filename), with following contents:

```json
{
    "tools": [
        {
            "name": "box",
            "summary": "Fast, zero config application bundler with PHARs",
            "website": "https://github.com/box-project/box",
            "command": {
                "phar-download": {
                    "phar": "https://github.com/box-project/box/releases/latest/download/box.phar",
                    "bin": "%target-dir%/box"
                }
            },
            "test": "",
            "tags": ["box"]
        }
    ]
}
```

The **tools/command** is mandatory and define how you'll grab a copy of the tool.

Here, we decide to download the latest [Phar](https://www.php.net/manual/en/book.phar.php) version available.
This is done with `phar-download` specialized command.
See <https://github.com/llaville/docker-php-toolbox/blob/master/src/Command/PharDownloadCommand.php>

By default, tools are installed in the `/usr/local/bin` directory.
To perform an installation in another location, don't forget to add the `%target-dir%` placeholder, to be able to replace it at runtime.

## Step 2 - (re)build the work Dockerfile

Before to rebuild the docker work image, you should update the work Dockerfile.
It can be done by running the following command:

```bash
bin/toolkit.php build:dockerfile -f ./Dockerfiles/work/Dockerfile <php_version>
```

Replace `<php_version>` by either 5.2, 5.3, 5.4, 5.5, 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3 or 8.4

**CAUTION** identify the right work Dockerfile with the `dockerfile` (or `f`) option. Default is for **mods** file.

**NOTE** if you want to perform installation in another location than `/usr/local/bin` default directory,
don't forget to pass the `--target-dir` option.

**NOTE** if your `resources` directory is located in another location than the one bundle with this project,
don't forget to pass the `--resources` option.

### Example

```bash
bin/toolkit.php build:dockerfile -f ./Dockerfiles/work/Dockerfile --resources /home/me/my-project/Dockerfiles/work/Dockerfile 7.4
```

Beware, if you plan to use this Toolbox for another target than the Devilbox project, don't forget to identify the right templates
of your Dockerfiles with the `f` or `dockerfile` option.

## Step 3 - (re)build the work Docker image

You are now ready to build the Docker work corresponding image with the following command:

```bash
bin/toolkit.php build:image -f ./Dockerfiles/work/Dockerfile <php_version>
```
