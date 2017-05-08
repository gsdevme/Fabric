.PHONY: all

default: all;

composer:
	composer install --no-scripts --prefer-stable

standards:
	vendor/bin/phpcs src --standard=psr2
	vendor/bin/phpcs tests --standard=psr2

mess:
	vendor/bin/phpmd src/ text codesize, controversial, design, naming, unusedcode

static-analysis:
	vendor/bin/phpstan analyse src --level 5
	vendor/bin/phpstan analyse -l 4 tests/

tests:
	vendor/bin/phpunit

all: standards mess static-analysis tests
