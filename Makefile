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

.PHONY: build
build: ## Build Project container
	docker-compose build fpm

.PHONY: start
start: .env docker-compose.override.yml ## Start docker-compose (with Docker-Sync if you work on Mac Os X)
ifeq ($(RUNNING),)
	docker-compose up -d
endif

.PHONY: stop
stop: .env docker-compose.override.yml ## Stop docker-compose (with Docker-Sync if you work on Mac Os X)
ifneq ($(RUNNING),)
	docker-compose down --remove-orphans
endif

.PHONY: cc
cc: ## [symfony] brutal cache clearer (useless on linux / useless with macOs)
	docker-compose exec fpm ash -c "rm -rf var/cache/*"

.PHONY: sf
sf: ## [symfony] entrypoint for a Symfony Command (exemple: make sf CMD=cache:clear)
	docker-compose exec fpm php bin/console $(CMD)

.PHONY: shell
shell: ## [shell] connection to php container php
	docker-compose exec fpm zsh

.PHONY: install
install: build start getvendor  ## Run Docker // Install application
	@read -p 'WARNING, if you press ENTER the database will be destroyed' FUBAR
	@echo 'Droping schema...'
	@$(MAKE) sf CMD='doctrine:schema:drop --force --no-interaction --quiet'
	@echo 'Creating schema...'
	@$(MAKE) sf CMD='doctrine:schema:create --no-interaction --quiet'
	@echo 'Please create admin user credentials:'
	$(MAKE) create-admin

.PHONY: shell
shell: start ## shell
	docker-compose exec fpm zsh

create-admin: start
	@read -p "Admin user email: " EAV_ADMIN_USERNAME && \
	read -p "Admin user password: " EAV_ADMIN_PASSWORD && \
	$(MAKE) sf CMD="eavmanager:create-user $${EAV_ADMIN_USERNAME} --admin --password=$${EAV_ADMIN_PASSWORD} --no-interaction"


.PHONY: sf-doctrine-create
sf-doctrine-create: ## [doctrine] database create
	@$(MAKE) sf CMD='doctrine:database:create --if-not-exists'

.PHONY: clean
clean: stop ## [project] clean your dev environnement of all artefacts (docker containers and associated volumes, vendor, docker-sync volumes)
	docker-compose down -v
	rm -rf vendor/

.PHONY: getvendor
getvendor: ## copy vendor (only for MacOS)
ifeq ($(OS),Darwin)
	docker cp $(shell docker ps --filter "name=$(COMPOSE_PROJECT_NAME)_fpm" --format "{{.Names}}"):/app/vendor .
endif

.PHONY: reset
reset: clean
	rm -f app/config/parameters.yml
	rm -rf var/cache/* var/data/* var/annotations var/logs/* var/sessions/*

.PHONY: logs
logs: ## [docker] show docker logs (you can specify a container with C='fpm')
	docker-compose logs $(C)


