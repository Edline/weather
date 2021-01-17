docker-build:
	docker-compose up --build -d

docker-composer-install:
	docker-compose exec php composer install
docker-php-migrate:
	docker-compose exec php php /var/www/html/bin/console app:weather-migrate
docker-api-weather:
	docker-compose exec php php /var/www/html/bin/console app:weather-api-save

docker-up:
	docker-compose up -d
docker-stop:
	docker-compose stop
docker-start:
	docker-compose start
docker-restart:
	docker-compose restart
