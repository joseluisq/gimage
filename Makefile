help:
	@echo "Please use \`make <target>' where <target> is one of:"
	@echo "  test           to perform unit tests."
	@echo "  format         to format the codebase."

test:
	vendor/bin/phpunit

format:
	phpcbf -w ./src ./tests --standard=PSR2
	phpcs ./src ./tests --standard=PSR2

.PHONY: test docs format
