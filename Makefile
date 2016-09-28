help:
	@echo "Please use \`make <target>' where <target> is one of:"
	@echo "  test           to perform unit tests.  Provide TEST to perform a specific test."

test:
	vendor/bin/phpunit
