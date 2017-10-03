help:
	@echo "Please use \`make <target>' where <target> is one of:"
	@echo "  test           to perform unit tests."
	@echo "  docs           to build the docs."
	@echo "  format         to format the codebase."

test:
	vendor/bin/phpunit

docs:
	-rm -rf _docs
	vendor/bin/apigen generate -s src -d ./_docs
	-git checkout gh-pages
	-rm -rf docs && mv -f ./_docs ./docs
	-git add -A && git commit . -m "update docs"
	-git push -u origin gh-pages
	@echo
	@echo "Docs built and published."

format:
	phpcbf -w ./src ./tests --standard=PSR2
	phpcs ./src ./tests --standard=PSR2

.PHONY: test docs format
