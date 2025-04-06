restart: down up

up:
	docker compose up -d
down:
	docker compose down
composer-install:
	composer install
