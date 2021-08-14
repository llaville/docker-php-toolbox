# Faster builds with Docker cache

### What you'll learn ?

- What tip we used to make version 1.0.0alpha2 faster than 1.0.0alpha1

### Audience

Developers, DevOps engineers, and Contributors with PHP and Docker skill.

### Step 1 - explains the Docker caching mechanisms

The [first alpha version](https://github.com/llaville/docker-php-toolbox/releases/tag/1.0.0alpha1) of prototype
uses benefits of [BuildKit](https://docs.docker.com/develop/develop-images/build_enhancements/#to-enable-buildkit-builds)
to speed up make of Docker Images.

Of course to use it you require at least Docker 19.03 (check it with command `docker --version`)

The second alpha version of prototype will come with more extensions (+40) and tools (+5) supported,
but also a speed optimization in building process.

Before to see why it's possible, we must learn how Docker Layer Caching works.

Docker caches each layer as an image is built, and each layer will only be re-built
if it or the layer above it has changed since the last build.
So, you can significantly speed up builds with Docker cache if you don't change layer order.

### Step 2 - explains alpha2 PHP changes

Once a new extension is added, the new corresponding layer (`RUN install-php-extensions <ext_name>`) is appended to command stack
rather than inserting in alphabetic order.

In `src/Collection/Tools.php`, we've extracted ordering collection process in new public method `sortByName()`.
The alphabetic order is only applied on `list:tools` , `list:extensions`, and `update:readme` commands,
while `build:dockerfile` command use only the Symfony Finder order results, return by `load()` method.
See commit [33967d7](https://github.com/llaville/docker-php-toolbox/commit/33967d777f0cabe9ea4859f17528d07ca411f253) for details of change.

### Step 3 - learn more about faster builds

Other tips to use cache as much as possible (already implemented since 1.0 alpha1) are explained very well in following articles :

* [Faster CI Builds with Docker Layer Caching and BuildKit](https://testdriven.io/blog/faster-ci-builds-with-docker-cache/)
* [Docker BuildKit: faster builds, new features, and now it’s stable](https://pythonspeed.com/articles/docker-buildkit/)
* [Advanced Dockerfiles: Faster Builds and Smaller Images Using BuildKit and Multistage Builds](https://www.docker.com/blog/advanced-dockerfiles-faster-builds-and-smaller-images-using-buildkit-and-multistage-builds/)
* [Build images with BuildKit](https://docs.docker.com/develop/develop-images/build_enhancements/)
* [Dockerfile frontend syntaxes](https://github.com/moby/buildkit/blob/master/frontend/dockerfile/docs/syntax.md) with BuildKit
* [Can php-extension-installer keep apt repo cache and downloaded packages?](https://github.com/mlocati/docker-php-extension-installer/issues/418)
