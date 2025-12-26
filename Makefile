DOCKER_CONTAINER_NAME = server_casfid_technical_test

up:
	docker-compose up -d

down:
	docker-compose down

php:
	docker container exec -it ${DOCKER_CONTAINER_NAME} bash

composer-install:
	docker container exec -it ${DOCKER_CONTAINER_NAME} composer install

migrations:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/console doctrine:migrations:migrate --no-interaction

scrap-news:
	docker container exec -it ${DOCKER_CONTAINER_NAME} php bin/console casfid:scrap-news

exec:
	docker container exec -it $(DOCKER_CONTAINER_NAME) $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
