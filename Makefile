TMP_DOCS=/tmp/_gimage_docs

help:
	@echo "Please use \`make <target>' where <target> is one of:"
	@echo "  test           to perform unit tests."
	@echo "  format         to format the codebase."

test:
	@vendor/bin/phpunit

docker-tests:
	@echo "Testing Gimage with PHP 7.4"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:7.4 \
		sh -c 'php -v && rm -rf vendor && composer install && composer run-script test'
	@echo
	@echo "Testing Gimage with PHP 8.0"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:8.0 \
		sh -c 'php -v && rm -rf vendor && composer install && composer run-script test'
.PHONY: docker-tests

format:
	@phpcbf -w ./src ./tests --standard=PSR2
	@phpcs ./src ./tests --standard=PSR2

docs:
	@mkdocs serve -e docs -a 0.0.0.0:8000

docs_deps:
	@pip3 install mkdocs pymdown-extensions mkdocs-material markdown

docs_build:
	mkdocs build -e docs -d $(TMP_DOCS)

docs_api:
	@mkdir -p site/api/v3.0
	@mkdir -p $(TMP_DOCS)/api/v3.0
	@vendor/bin/apigen generate -s src -d $(TMP_DOCS)/api/v3.0

docs_deploy:
	@composer install
	@rm -rf $(TMP_DOCS)
	@make docs_build
	@make docs_api
	@git checkout gh-pages
	@git add . && git rm -fr .
	@git clean -df
	@cp -a $(TMP_DOCS)/. ./
	@git add . && git commit . -m "automatic documentation updates"
	@git push -u origin gh-pages
	@rm -rf $(TMP_DOCS)
	@echo
	@echo "Documentation built and published."

.PHONY: test docs format docs docs_deps docs_api docs_deploy
