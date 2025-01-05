.DEFAULT_GOAL := help

DC = docker-compose
ifeq (, $(shell which $(DC)))
  DC = docker compose
endif
EXEC = $(DC) exec -u www-data app
SYMFONY = $(EXEC) bin/console
COMPOSER = $(EXEC) composer


RED := $(shell tput -Txterm setaf 1)
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)
TARGET_MAX_CHAR_NUM=30

help:
	@echo "Nursery Management ${GREEN}API${RESET}"
	@awk '/^[a-zA-Z\-_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")-1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  ${GREEN}%-$(TARGET_MAX_CHAR_NUM)s${RESET} %s\n", helpCommand, helpMessage; \
		} \
		isTopic = match(lastLine, /^###/); \
	    if (isTopic) { \
			topic = substr($$1, 0, index($$1, ":")-1); \
			printf "\n${YELLOW}%s${RESET}\n", topic; \
		} \
	} { lastLine = $$0 }' $(MAKEFILE_LIST)


####################################### INSTALL #######################################

###
Install:

## Run docker exec to enter the application container
shell:
	@$(EXEC) bash

## Run docker exec to enter the database container
database:
	@$(DC) exec -u www-data database mysql --user=symfony --password=symfony --host=localhost nursery


## Install the dev environment
install:
	@$(DC) build
	@$(MAKE) start -s
	@$(MAKE) vendor -s
	@$(MAKE) db-reset -s
	@$(SYMFONY) messenger:setup-transports


## Install the composer dependencies
vendor: composer.lock
	@$(COMPOSER) install --optimize-autoloader

## Docker compose the project
start:
	@$(DC) up -d --remove-orphans

## Stop the project
stop:
	@$(DC) kill
	@$(DC) rm -v --force

.PHONY: shell database install vendor start stop


####################################### DATABASE #######################################


###
Database:

## Create the database
db-create:
	@$(SYMFONY) doctrine:database:drop --force --if-exists -nq
	@$(SYMFONY) doctrine:database:create -nq

## Run migrations
db-migrate:
	@$(SYMFONY) doctrine:migrations:migrate -nq --allow-no-migration

## Create admin agent
db-manager:
	@$(SYMFONY) app:create:manager

## Create agent
db-agent:
	@$(SYMFONY) app:create:agent

## Fixtures
db-fixtures:
	@$(SYMFONY) doctrine:fixtures:load -nq

## Reset database
db-reset: db-create db-migrate db-fixtures db-manager db-agent


####################################### MESSENGER #######################################


###
Messenger:

## Stop active messenger workers
stop-workers:
	@$(SYMFONY) messenger:stop-workers

## Launch a worker in the foreground to consume messages
consume:
	@$(SYMFONY) messenger:consume async -vv

.PHONY: stop-workers consume


####################################### TOOLS #######################################


###
Tools:

## Clear Symfony cache
cc:
	@$(SYMFONY) cache:clear -e dev
	@$(SYMFONY) doctrine:cache:clear-metadata --flush -e dev
	@$(SYMFONY) cache:clear -e test
	@$(SYMFONY) doctrine:cache:clear-metadata --flush -e test

## Code cleaner
fix-cs:
	@$(EXEC) sh -c "PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --config=tools/.php-cs-fixer.dist.php --cache-file=tools/.php-cs-fixer.cache --verbose"

## Code analyze
phpstan:
	@$(EXEC) vendor/bin/phpstan analyze -c tools/phpstan.neon --memory-limit 1G

## Check ddd and bounded context dependencies
deptrac:
	@echo "\n\e[7mChecking DDD layers...\e[0m"
	@$(EXEC) vendor/bin/deptrac --cache-file=tools/.deptrac_ddd.cache --config-file=tools/deptrac_ddd.yaml

	@echo "\n\e[7mChecking Bounded context layers...\e[0m"
	@$(EXEC) vendor/bin/deptrac --cache-file=tools/.deptrac_bounded_context.cache --config-file=tools/deptrac_bounded_context.yaml

## Run security analysis
security:
	@$(EXEC) composer audit

## Run tools
check: cc fix-cs phpstan deptrac security

.PHONY: cc fix-cs phpstan deptrac security


####################################### TESTS #######################################


###
Tests:

## Behat tests
behat: db-create db-migrate stop-workers
	@$(EXEC) vendor/bin/behat -n --strict --format=progress --config tools/behat.yaml

## Behat tests in progress
behat-test:
	@$(EXEC) vendor/bin/behat -n --strict --format=progress --config tools/behat.yaml --tags="@test"