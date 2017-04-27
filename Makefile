help:
	@echo "Please use \`make <target>' where <target> is one of:"
	@echo "  test           to perform unit tests.  Provide TEST to perform a specific test."

test:
	vendor/bin/phpunit

docs:
	vendor/bin/apigen generate -s src -d docs
