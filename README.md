# PHP Developer test task

## Проект Weather Api.

Установка:

`docker-compose up --build -d`

`docker-compose exec php composer install`

Миграция

`docker-compose exec php php /var/www/html/bin/console app:weather-migrate`

Сохранеиние данных с www.weatherapi.com

`docker-compose exec php php /var/www/html/bin/console app:weather-api-save`

Конфигурационный файл
`./config/weather/weather.yaml`