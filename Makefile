## Run phpunit tests
test-phpunit:
	php vendor/bin/phpunit

php-stan-impl:
	vendor/bin/phpstan analyse -l 6 app/Impl

php-stan-controller:
	vendor/bin/phpstan analyse -l 6 app/Http/Controllers
