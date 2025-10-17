DOCKER=docker
DOCKER_COMPOSE := $(shell command -v docker-compose >/dev/null 2>&1 && echo docker-compose || echo docker compose)
APP_DESAFIO_AIQFOME=app-desafio-aiqfome
ENV_FILE := .env.compose

setup-env:
	@[ -f .env ] || cp src/.env.example src/.env	

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

generate-key:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan key:generate

run-composer-install:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) composer install

seed:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan db:seed

ps:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) ps

bash:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) bash

tinker:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan tinker

cache-clear:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan cache:clear
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan config:clear
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan view:clear
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan route:clear
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) composer dump-autoload

test:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan test

documentation:
	make cache-clear
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) php artisan l5-swagger:generate

inicializa-aplicacao:
	make build
	make setup-env
	make up
	make run-composer-install
	make generate-key
	make migrate-status
	make migrate
	make migrate-status
	make seed
	make documentation
	make test

help:
	@echo "Comandos Facilitadores desafio aiqfome:"
	@echo "  up      		- Inicia os containers em modo detached"
	@echo "  build   		- Build dos containers em modo detached"
	@echo "  down    		- Para e remove os containers"
	@echo "  logs    		- Mostra os logs dos containers"
	@echo "  cache-clear           - limpa caches do Laravel"	
	@echo "  ps      		- Lista os status dos containers"
	@echo "  migrate 		- Executa migrations pendentes"
	@echo "  migrate-status 	- Mostra o status das migrations"
	@echo "  seed   		- Executa os seeders do banco de dados"
	@echo "  test   		- Executa os testes especificados"
	@echo "  tinker 		- Abre o tinker no container app"
	@echo "  bash   		- Abre o bash no container app"
	@echo "  documentation  	- Gera documentação da api atualizada"
	@echo "  help   		- Mostra os comandos configurados para o Makefile"

.PHONY: up build down logs ps migrate migrate-status seed test tinker bash documentation help   		