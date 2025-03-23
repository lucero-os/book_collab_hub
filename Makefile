# Makefile for Dockerized Laravel app

# Set project name (useful for naming containers)
PROJECT_NAME = book_collab_app

# Docker Compose file
DOCKER_COMPOSE = docker-compose -p $(PROJECT_NAME)

# Default service to run
SERVICE = app

# Commands
fromScratch: build up migrate seed

build: ## Build the Docker images for the app, MySQL, and Redis
	$(DOCKER_COMPOSE) build

up: ## Start the app, MySQL, and Redis containers in the background
	$(DOCKER_COMPOSE) up -d

down: ## Stop and remove the app, MySQL, and Redis containers
	$(DOCKER_COMPOSE) down

logs: ## View logs for all containers
	$(DOCKER_COMPOSE) logs -f

migrate: ## Run database migrations inside the container
	$(DOCKER_COMPOSE) exec $(SERVICE) php artisan migrate

seed: ## Run database seeding inside the container
	$(DOCKER_COMPOSE) exec $(SERVICE) php artisan db:seed

install: ## Install Laravel dependencies
	$(DOCKER_COMPOSE) exec $(SERVICE) composer install

serve: ## Start the Laravel server inside the Docker container
	$(DOCKER_COMPOSE) exec $(SERVICE) php artisan serve --host=0.0.0.0 --port=8000

db_create: ## Create MySQL database if not exists
	$(DOCKER_COMPOSE) exec $(SERVICE) php artisan migrate:install

redis: ## Connect to the Redis container
	$(DOCKER_COMPOSE) exec redis redis-cli

# Prune unused Docker images and containers
prune: ## Remove all unused containers, images, and volumes
	docker system prune -f

help: ## Show help message
	@echo "Available make commands:"
	@echo "  fromScratch   Build and run project"
	@echo "  build         Build Docker images for app, MySQL, and Redis"
	@echo "  up            Start containers"
	@echo "  down          Stop and remove containers"
	@echo "  logs          View logs for all containers"
	@echo "  migrate       Run database migrations"
	@echo "  seed          Run database seeding"
	@echo "  install       Install Laravel dependencies"
	@echo "  serve         Start Laravel server"
	@echo "  db_create     Create MySQL database if not exists"
	@echo "  redis         Connect to the Redis container"
	@echo "  prune         Remove unused Docker containers, images, and volumes"

