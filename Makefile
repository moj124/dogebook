#Makefile variables, make code simplier
COMPOSE ?= composer
DOCKER_COMPOSE ?= docker-compose
DOCKER_RUN ?= ${DOCKER_COMPOSE} run 
SYMFONY_BIN ?= symfony
YARN ?= yarn

# PHONY sets a virtual target when running Makefile commands, avoids targetting real files!
# -----------------------------------------------------------------------------------------------
# To make Entities - php bin/console make:entity


# run tests
tests:
	./vendor/bin/simple-phpunit
.PHONY: tests
# migrate database to latest structure
migrate:
	php bin/console doctrine:migrations:migrate
.PHONY: migrate

# update dependencies
update:
	${COMPOSE} update
.PHONY: update
# removes all containers associated with dogebooook
down:
	${DOCKER_COMPOSE} down
.PHONY: down

# starts the mailer, database images which runs in the an isolated environment
up-all:
	${DOCKER_COMPOSE} up -d database
.PHONY: up-all

# starts the symfony server in a isolated environment, with the default port 8000
serve:
	${SYMFONY_BIN} serve -d
.PHONY: serve

fe-install:
	${YARN} install
	${YARN} build
.PHONY: fe

# Useful aliases
# -----------------------------------------------------------------------------------------------

# first remove all docker containers if still running start up mailer, database images
dev: down up-all serve
.PHONY: dev

check: update down fe up-all tests down
.PHONY: check
