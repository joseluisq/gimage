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

docs_api:
	mkdir -p site/api/v3.0
	vendor/apigen/apigen/bin/apigen generate -s src -d ./site/api/v3.0

docs_deploy:
	-make docs_build
	-cd ../.
	-make docs_api
	-rm -rf /tmp/_gimage_docs
	-mv -f ./site /tmp/_gimage_docs
	-git branch -d gh-pages
	-git checkout --orphan gh-pages
	-git rm --cached -r .
	-cp -rf /tmp/_gimage_docs/* ./
	-git add -A && git commit . -m "update docs"
	-git push -u origin gh-pages
	-rm -rf /tmp/_gimage_docs
	-echo
	-echo "Docs built and published."

.PHONY: test docs format docs docs_api docs_deploy
