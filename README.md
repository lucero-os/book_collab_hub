# Project Name: Dockerized Laravel App

## Introduction
This project is a fully dockerized Laravel application that includes MySQL for database storage and Redis for caching. 
The setup is streamlined using a `Makefile` to simplify common tasks like building, starting, and stopping the environment.

## Technology argument
* Laravel 12: Discover laravel's most recent features.
* Mysql: Constrained relationships.
* Redis: Swift implementation and quick responses to heavy queries.
* Swagger: Clear and user friendly api docs.

## Brief
This API was developed for a team to collaborate on books. Each book has sections, with unlimited sub-sections.
Users have different roles:
* Author: Is able to create and edit books' sections, and able to grant permissions to **collaborators** to create new sections.
* Collaborator: Is able to edit books' sections, and eligible to create new sections.

## Prerequisites
Before running the project, ensure you have the following installed:
- **Docker** (https://www.docker.com/get-started)
- **Docker Compose** (included with Docker Desktop)
- **Make** (comes pre-installed on macOS/Linux; Windows users may need to install GNU Make)

## Installation and Setup

### 1. Clone the repository
```bash
git clone https://github.com/your-repo-name.git
cd your-repo-name
```

### 2. Update docker-compose file db and cache volumes to your project path
```bash
volumes: 
  - {your_project_path}book_collab_challenge/redis/tmp/:/data
```

### 3. Set Up the Environment updating project .env using api/.env.example as template.

### 4. Start and run project from scratch
```bash
make fromScratch
```
This command builds the necessary images for the Laravel application, MySQL, and Redis, starts up project and runs migrations and seeders.

### 6. Generate the Application Key
```bash
docker-compose exec app php artisan key:generate
```

## Stopping the Project
To stop the running containers:
```bash
make stop
```
This will stop and remove the Laravel, MySQL, and Redis containers.

## API Documentation
Exposed endpoints in swagger for tryout on /api/documentation#/

## Troubleshooting
- Run `docker-compose ps` to check if all containers are running.
- If changes are not reflected, try restarting the containers:
  ```bash
  make down && make up
  ```

## Conclusion
This setup provides a quick way to run a Laravel application with MySQL and Redis in Docker, making it easy to develop and maintain. 
Use the provided `Makefile` commands to streamline common tasks and speed up the development process.
