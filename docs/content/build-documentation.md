# Building documentation from source

All HTML documentation is located in the `docs/` project's directory and is built using [Material for MkDocs](https://github.com/squidfunk/mkdocs-material).

It's only necessary to have [Docker](https://www.docker.com/get-started/) installed.

## Building documentation

By default the docs will be built in the `/tmp/docs` directory, to do so follow these steps.

```sh
git clone https://github.com/joseluisq/gimage.git
cd gimage
mkdir /tmp/docs
docker run -it --rm \
    -v $PWD/docs:/docs \
    -v /tmp/docs:/tmp/docs squidfunk/mkdocs-material build
```

!!! tip "Output the docs in a different directory"
    If you want to output the docs in a different directory then append the `--site-dir=/new/dir/path/` argument to the *"squidfunk/mkdocs-material"* `build` command and make sure to provide the new directory path.

## Development server

If you want to improve the documentation then run the built-in development server via `docs/docker-compose.yml`.

```sh
git clone https://github.com/joseluisq/gimage.git
cd gimage
docker-compose -f docs/docker-compose.yml up
```

Now the server will be available at `localhost:8000`
