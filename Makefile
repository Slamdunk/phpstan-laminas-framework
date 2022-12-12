all: csfix static-analysis test
	@echo "Done."

vendor: composer.json
	composer update --ignore-platform-req=php
	touch vendor

.PHONY: csfix
csfix: vendor
	php8.1 vendor/bin/php-cs-fixer fix --verbose

.PHONY: static-analysis
static-analysis: vendor
	vendor/bin/phpstan analyse

.PHONY: test
test: vendor
	php -d zend.assertions=1 vendor/bin/phpunit ${arg}
