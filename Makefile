all: csfix static-analysis test
	@echo "Done."

vendor: composer.json
	composer update --ignore-platform-reqs
	touch vendor

.PHONY: csfix
csfix: vendor
	vendor/bin/php-cs-fixer fix --verbose

.PHONY: static-analysis
static-analysis: vendor
	vendor/bin/phpstan analyse

.PHONY: test
test: vendor
	php -d zend.assertions=1 vendor/bin/phpunit ${arg}
