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
	@docker run -it --rm -p 8000:8000 -v $(PWD)/docs:/docs squidfunk/mkdocs-material
.PHONY: docs-dev

docs-build:
	@docker run -it --rm -v $(TMP_DOCS):$(TMP_DOCS) -w $(TMP_DOCS) alpine sh -c 'rm -rf $(TMP_DOCS)/*'
	@docker run -it --rm -v $(PWD)/docs:/docs -v $(TMP_DOCS):$(TMP_DOCS) squidfunk/mkdocs-material build
	@echo "Docs generated on $(TMP_DOCS)"
.PHONY: docs-build

docs-api:
	@docker run -it --rm -v $(TMP_DOCS):$(TMP_DOCS) -w $(TMP_DOCS) alpine sh -c 'mkdir -p api/v4.0'
	@docker run -it --rm -v $(TMP_DOCS):$(TMP_DOCS) -v $(PWD)/src:/data phpdoc/phpdoc \
		--target $(TMP_DOCS)/api/v4.0/ --cache-folder /tmp/.phpdoc
	@echo "API docs generated on $(TMP_DOCS)/api/v4.0"
.PHONY: docs-api

docs-deploy:
	@make docs-build
	@make docs-api
	@git checkout gh-pages
	@docker run -it --rm -v $(PWD):/data -u $$(id -u):$$(id -g) -w /data alpine/git clean -fdx
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
