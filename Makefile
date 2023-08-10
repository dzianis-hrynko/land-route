SHELL=/bin/bash

export UID := $(shell id -u)
export GID := $(shell id -g)

build:
	docker-compose -f docker-compose.roadrunner.yml build
up:
	docker-compose -f docker-compose.roadrunner.yml up --remove-orphans

build-dev:
	docker build . -f Dockerfile --tag land-route:dev

composer-install:
	docker run --rm -w /application -v $(pwd):/application land-route:dev composer install

unit-tests:
	docker run --rm -w /application -v $(pwd):/application land-route:dev vendor/bin/phpspec run

feature-tests:
	docker run --rm -w /application -v $(pwd):/application land-route:dev vendor/bin/behat