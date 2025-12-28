DOCKER_CONTAINER_NAME = server_casfid_technical_test

up:
	docker-compose up -d

down:
	docker-compose down

php:
	docker container exec -it ${DOCKER_CONTAINER_NAME} bash

setup: composer-install migrations

composer-install:
	docker container exec -it ${DOCKER_CONTAINER_NAME} composer install

migrations:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/console doctrine:migrations:migrate --no-interaction

populate-bbdd:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/console doctrine:fixtures:load

scrap-news:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/console casfid:scrap-news -v

messenger-consume:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/console messenger:consume async -vv

phpunit:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/phpunit
