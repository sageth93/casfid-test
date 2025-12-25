DOCKER_CONTAINER_NAME = server_casfid_technical_test

up:
	docker-compose up -d

down:
	docker-compose down

php:
	docker container exec -it ${DOCKER_CONTAINER_NAME} bash

composer-install:
	docker container exec -it ${DOCKER_CONTAINER_NAME} composer install

exec:
	docker container exec -it $(DOCKER_CONTAINER_NAME) $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
