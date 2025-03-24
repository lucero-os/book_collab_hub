# Project Name: Book collab hub

## Introduction
This project is a fully dockerized Laravel application that includes MySQL for database storage and Redis for caching. 
The setup is streamlined using a `Makefile` to simplify common tasks like building, starting, and stopping the environment.

## Technology argument
* Laravel 12: Discover laravel's most recent features.
* Mysql: Strong relational integrity with enforced constraints, ensuring data consistency.
* Redis: Swift implementation and quick responses to heavy queries, reducing database load.
* Swagger: Clear and user friendly api docs.
* Docker: Portable and consistent environment across OSes, seamless project setup and deployment.
* JWT: Stateless, secure authentication ideal for APIs, reducing the need for server-side session storage.

## Brief
This API was developed for a team to collaborate on books. Each book has sections, with unlimited sub-sections.
I used a self reference trait to make querying nested sub-sections clean and understandable. 
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
git clone https://github.com/lucero-os/book_collab_hub.git
cd book_collab_hub
```

### 2. Update docker-compose file db and cache volumes to your project path
```bash
cache:
  volumes: 
    - {your_project_path}/book_collab_hub/redis/tmp/:/data
db:
  volumes:
      - {your_project_path}/book_collab_hub/mysql/tmp/:/docker-entrypoint-initdb.d
```

### 3. Set Up the Environment creating project api/.env taking api/.env.example as template.

### 4. Start and run project from scratch
```bash
make fromScratch
```
This command builds the necessary images for the Laravel application, MySQL, and Redis, starts up project and runs migrations and seeders.

## Stopping the Project
To stop the running containers:
```bash
make down
```
This will stop and remove the Laravel, MySQL, and Redis containers.

## Starting back
To run containers:
```bash
make up
```
This will start the Laravel, MySQL, and Redis containers.

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
