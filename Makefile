help:
	@echo "Please use \`make <target>' where <target> is one of:"
	@echo "  test           to perform unit tests."
	@echo "  format         to format the codebase."

test:
	vendor/bin/phpunit

format:
	phpcbf -w ./src ./tests --standard=PSR2
	phpcs ./src ./tests --standard=PSR2

docs:
	cd docs
	mkdocs serve -a 0.0.0.0:8000

docs_build:
	cd docs
	mkdocs build

docs_deploy:
	make docs_build
	mkdocs gh-deploy

docs_api:
	-rm -rf _docs
	vendor/bin/apigen generate -s src -d ./_docs
	-git checkout gh-pages
	-mkdir -p
	-rm -rf docs && mv -f ./_docs ./api/v3.0
	-git add -A && git commit . -m "update docs"
	-git push -u origin gh-pages
	@echo
	@echo "Docs built and published."

.PHONY: test docs format docs docs_api docs_deploy
