# Variáveis
DOCKER_COMPOSE = docker compose
DOCKER_EXEC = docker exec -it
BACKEND_CONTAINER = backend
ENV_PATH = backend/.env
ENV_EXAMPLE_PATH = backend/.env.example
MYSQL_ROOT_PASSWORD = t00r@
MYSQL_DATABASE = laravel
MYSQL_USER = system
MYSQL_PASSWORD = syst3m@

# Comandos
up:
	$(DOCKER_COMPOSE) up -d

env:
	@if [ ! -f $(ENV_PATH) ]; then cp $(ENV_EXAMPLE_PATH) $(ENV_PATH); fi
	@sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' $(ENV_PATH)
	@sed -i 's/^DB_HOST=.*/DB_HOST=database/' $(ENV_PATH)
	@sed -i 's/^DB_PORT=.*/DB_PORT=3306/' $(ENV_PATH)
	@sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$(MYSQL_DATABASE)/" $(ENV_PATH)
	@sed -i "s/^DB_USERNAME=.*/DB_USERNAME=$(MYSQL_USER)/" $(ENV_PATH)
	@sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$(MYSQL_PASSWORD)/" $(ENV_PATH)

install:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) composer install

key-generate:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) php artisan key:generate

jwt-secret:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) php artisan jwt:secret

migrate:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) php artisan migrate

setup: env up install key-generate jwt-secret migrate
	@echo "Projeto configurado com sucesso!"
