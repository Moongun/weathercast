go-php:
	docker compose exec -u 1000:1000 php sh

test:
	docker compose exec php bin/phpunit
