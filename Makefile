#Makefile variables, make code simplier
DOCKER_COMPOSE ?= docker-compose

# removes all containers associated with dogebooook
# PHONY sets a virtual target `down` when running Makefile commands, avoids targetting real files!
down:
	${DOCKER_COMPOSE} down
.PHONY: down

# starts the mailer, database & web images which runs in the an isolated environment
# PHONY sets a virtual target `up-all` when running Makefile commands, avoids targetting real files!
up-all:
	${DOCKER_COMPOSE} up mailer database web -d
.PHONY: up-all


# Useful aliases
# -----------------------------------------------------------------------------------------------

# first remove all docker containers if still running & start up mailer, database & web images
# PHONY sets a virtual target `dev` when running Makefile commands, avoids targetting real files!
dev: down up-all
.PHONY: dev