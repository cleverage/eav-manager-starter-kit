OS := $(shell uname)

.PHONY: help
help: ## This help
	@grep -Eh '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

-include .env
.env:
	cp .env.dist .env
	$(MAKE) .env

RUNNING:=$(shell docker ps -q --filter status=running --filter name=^/$(COMPOSE_PROJECT_NAME) | xargs)

.PHONY: install
install: start  ## Run Docker // Install application (composer install)

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
	docker-compose stop
ifeq ($(OS),Darwin)
	docker-sync stop
endif
endif

.PHONY: sf
sf: ## [symfony] entrypoint for a Symfony Command (exemple: make sf CMD=cache:clear)
	docker-compose exec fpm php bin/console $(CMD)

.PHONY: bash
bash: ## [shell] connection to php container php
	docker-compose exec fpm zsh

.PHONY: sf-doctrine-update
sf-doctrine-update: ## [doctrine] schema update
	@$(MAKE) sf CMD='doctrine:schema:update --force'

.PHONY: shell
shell: start ## Deploy to staging
	$(DC) exec www zsh

.PHONY: clean
clean: stop
	docker-compose down -v
	docker-sync clean
	rm -rf vendor/

.PHONY: init
init: ### init database and eav user
	$(MAKE) sf-doctrine-update
	$(MAKE) sf CMD='eavmanager:create-user $(EAV_ADMIN_USERNAME) --admin --password=$(EAV_ADMIN_PASSWORD) --no-interaction'