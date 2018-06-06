.PHONY: all

default: all;

composer:
	composer install --no-scripts --prefer-stable

fix-standards:
	vendor/bin/phpcbf src  --standard=ruleset.xml -p --colors

standards:
	vendor/bin/phpcs src  --standard=ruleset.xml -p --colors
	vendor/bin/phpcs tests --standard=psr2

static-analysis:
	vendor/bin/phpstan.phar analyse -l 7 src
	vendor/bin/phpstan.phar analyse -l 4 tests

tests:
	vendor/bin/phpunit

code-coverage:
	vendor/bin/phpunit --coverage-html=coverage

mess:
	vendor/bin/phpmd src/ text vendor/markup/coding-standard/phpmd.xml

all: standards static-analysis mess tests
