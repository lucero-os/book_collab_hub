# Makefile for Dockerized Laravel app

# Constants
PROJECT_NAME = book_collab_app
DOCKER_COMPOSE = docker-compose -p $(PROJECT_NAME)
## Default service to run
SERVICE = app

# Commands
# Build and run project from scratch
fromScratch: build up key migrate seed

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

key: ## Generate the Application Key
	$(DOCKER_COMPOSE) exec $(SERVICE) php artisan key:generate

lupdate: ## Update Laravel dependencies
	$(DOCKER_COMPOSE) exec $(SERVICE) composer update

# Prune unused Docker images and containers
prune: ## Remove all unused containers, images, and volumes
	docker system prune -f

hardPrune: ## Remove all containers, images, and volumes
	docker builder prune -a -f

help: ## Show help message
	@echo "Available make commands:"
	@echo "  fromScratch   	Start and run project from scratch"
	@echo "  build         	Build Docker images for app, MySQL, and Redis"
	@echo "  up            	Start containers"
	@echo "  down          	Stop and remove containers"
	@echo "  logs          	View logs for all containers"
	@echo "  migrate       	Run database migrations"
	@echo "  seed          	Run database seeding"
	@echo "  key			Generate the Application Key"
	@echo "  lupdate       	Update Laravel dependencies"
	@echo "  prune         	Remove unused Docker containers, images, and volumes"

