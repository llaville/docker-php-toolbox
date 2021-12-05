<!-- markdownlint-disable MD013 -->
# Contributing

This project is still a young project with an existing [roadmap](../ROADMAP.md),
and is positioned as a real compatible [Devilbox](https://github.com/cytopia/devilbox) alternative.

Any kind of contribution is welcome.

Visit the forums

* for [announcements](https://github.com/llaville/docker-php-toolbox/discussions/categories/announcements) of new versions
* if you want to [ask a question or help others](https://github.com/llaville/docker-php-toolbox/discussions/categories/q-a)
* [learn](https://github.com/llaville/docker-php-toolbox/discussions/categories/show-and-tell) more about any features
* suggest new [ideas](https://github.com/llaville/docker-php-toolbox/discussions/categories/ideas)
* or any [other stuffs](https://github.com/llaville/docker-php-toolbox/discussions/categories/general)

## Getting started

If you want to send a Pull Request, have these steps in mind :

- Create a new branch : `git checkout -b <my_new_tool>` (feel free to name your branch as you want)

- Declare your new tool with a json file into `resources/tools` directory.
  These properties are required:  `name`, `summary`, `website`, `command`

  Its depends on tool installation:
  - See `resources/tools/phplint.json` for a **git clone + composer install** example
  - See `resources/tools/phpcs.json` for a **phar installation** example
  - See `resources/tools/phpbu.json` for a **phive installation** example
  - See `resources/tools/httpie.json` for a **Python pip installation** example
  - See `resources/tools/laravel.json` for a **composer global require** example
  - See `resources/tools/tig.json` for a **shell installation** example
  - See `resources/tools/yarn.json` for a **npm node installation** example
  - See `resources/tools/yq.json` for a **file download + shell installation** example

- To add a new tool, you must have to include an up-to-date documentation page
  - [docs/appendix/tools.md](appendix/tools.md); please use `bin/devkit.php update:tools` command
