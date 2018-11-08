OS := $(shell uname)

.PHONY: help
help: ## This help
	@grep -Eh '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

-include .env
.env:
	$(MAKE) .env

RUNNING:=$(shell docker ps -q --filter status=running --filter name=^/$(COMPOSE_PROJECT_NAME) | xargs)

docker-compose.override.yml:
ifeq ($(OS),Darwin)
	cp docker-compose.macos.yml.dist docker-compose.override.yml
endif

.PHONY: start
start: .env docker-compose.override.yml ## Start docker-compose (with Docker-Sync if you work on Mac Os X)
ifeq ($(RUNNING),)
ifeq ($(OS),Darwin)
	docker-sync start
endif
	docker-compose up -d
endif

.PHONY: stop
stop: .env docker-compose.override.yml ## Stop docker-compose (with Docker-Sync if you work on Mac Os X)
ifneq ($(RUNNING),)
	docker-compose down --remove-orphans
ifeq ($(OS),Darwin)
	docker-sync stop
endif
endif

.PHONY: sf
sf: ## [symfony] entrypoint for a Symfony Command (exemple: make sf CMD=cache:clear)
	docker-compose exec fpm php bin/console $(CMD)

.PHONY: shell
shell: ## [shell] connection to php container php
	docker-compose exec fpm zsh

.PHONY: install
install: start  ## Run Docker // Install application
	@read -p 'WARNING, if you press ENTER the database will be destroyed' FUBAR
	@echo 'Droping schema...'
	@$(MAKE) sf CMD='doctrine:schema:drop --force --no-interaction --quiet'
	@echo 'Creating schema...'
	@$(MAKE) sf CMD='doctrine:schema:create --no-interaction --quiet'
	@echo 'Please create admin user credentials:'
	$(MAKE) create-admin

.PHONY: shell
shell: start ## Deploy to staging
	$(DC) exec www zsh

create-admin: start
	@read -p "Admin user email: " EAV_ADMIN_USERNAME && \
	read -p "Admin user password: " EAV_ADMIN_PASSWORD && \
	$(MAKE) sf CMD="eavmanager:create-user $${EAV_ADMIN_USERNAME} --admin --password=$${EAV_ADMIN_PASSWORD} --no-interaction"

.PHONY: clean
clean: stop
	docker-compose down -v
ifeq ($(OS),Darwin)
	docker-sync clean
endif
	rm -rf vendor/

.PHONY: reset
reset: clean
	rm -f app/config/parameters.yml
	rm -rf var/cache/* var/data/* var/annotations var/logs/* var/sessions/*
