TMP_DOCS=/tmp/docs

docker-tests:
	@echo "Testing Gimage with PHP 7.4"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:7.4 \
		sh -c 'php -v && composer install && composer run-script test'
	@echo
	@echo "Testing Gimage with PHP 8.0"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:8.0 \
		sh -c 'php -v && composer install && composer run-script test'
	@echo
	@echo "Testing Gimage with PHP 8.1"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:8.1 \
		sh -c 'php -v && composer install && composer run-script test'
.PHONY: docker-tests

docker-format:
	@echo "Formatting Gimage with PHP 8.0"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:8.0 \
		sh -c 'php -v && composer run-script format'
.PHONY: docker-format

docs-dev:
	@docker-compose -f docs/docker-compose.yml up --build
.PHONY: docs-dev

docs-build:
	@docker run -it --rm -v $(PWD)/docs:/docs -v $(TMP_DOCS):$(TMP_DOCS) squidfunk/mkdocs-material build
.PHONY: docs-build

docs-api:
	@mkdir -p site/api/v4.0
	@mkdir -p $(TMP_DOCS)/api/v4.0
	@docker run --rm -v $(PWD)/src:/data phpdoc/phpdoc
	@cp -r src/.phpdoc/build/. $(TMP_DOCS)/api/v4.0/
.PHONY: docs-api

docs-deploy:
	@git stash
	@rm -rf $(TMP_DOCS)
	@mkdir -p $(TMP_DOCS)
	@make docs-build
	@make docs-api
	@git checkout gh-pages
	@git clean -fdx
	@rm -rf docs/
	@mkdir -p docs/
	@cp -rf $(TMP_DOCS)/. docs/
	@git add docs/
	@git commit docs/ -m "docs: automatic documentation updates [skip ci]"
	@git push origin gh-pages
	@git push github gh-pages
	@echo
	@echo "Documentation built and published"
	@git checkout master
.PHONY: docs-deploy
