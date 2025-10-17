DOCKER=docker
DOCKER_COMPOSE := $(shell command -v docker-compose >/dev/null 2>&1 && echo docker-compose || echo docker compose)
APP_DESAFIO_AIQFOME=app-desafio-aiqfome
ENV_FILE := .env.compose

up:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) up -d

build:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) up -d --build

down:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) down

logs:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) logs -f --tail=200

migrate:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan migrate

migrate-status:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan migrate:status

seed:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan db:seed

ps:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) ps

bash:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) bash

tinker:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan tinker

test:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan test

help:
	@echo "Comandos Facilitadores desafio aiqfome:"
	@echo "  up      		- Inicia os containers em modo detached"
	@echo "  build   		- Build dos containers em modo detached"
	@echo "  down    		- Para e remove os containers"
	@echo "  logs    		- Mostra os logs dos containers"
	@echo "  ps      		- Lista os status dos containers"
	@echo "  migrate 		- Executa migrations pendentes"
	@echo "  migrate-status 	- Mostra o status das migrations"
	@echo "  seed   		- Executa os seeders do banco de dados"
	@echo "  test   		- Executa os testes especificados"
	@echo "  tinker 		- Abre o tinker no container app"
	@echo "  bash   		- Abre o bash no container app"
	@echo "  help   		- Mostra os comandos configurados para o Makefile"

.PHONY: up build down logs migrate migrate-status seed ps bash tinker help