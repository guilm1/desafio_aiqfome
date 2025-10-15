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

ps:
	$(DOCKER_COMPOSE) --env-file $(ENV_FILE) ps

bash:
	$(DOCKER) exec -it $(APP_DESAFIO_AIQFOME) bash

help:
	@echo "Makefile commands:"
	@echo "  up     - Inicia os containers em modo detached"
	@echo "  build  - Build dos containers em modo detached"
	@echo "  down   - Para e remove os containers"
	@echo "  logs   - Mostra os logs dos containers"
	@echo "  ps     - Lista os status dos containers"
	@echo "  bash   - Abre o bash no container app"
	@echo "  help   - Mostra os comandos configurados para o Makefile"