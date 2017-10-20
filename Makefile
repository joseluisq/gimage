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

.PHONY: test docs format docs
