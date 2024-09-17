# Testing project

## Project setup

### 1. Go to the project
```
    cd testing
```
### 2. Create .env file in project dir and add data from .env.dist
```
    touch .env
```
### 3. Create .env file for docker. Go to docker director, create .env and add data from .env.dist
```
    cd /docker
    touch .env
```
### 4. Build docker containers
```
    cd ../
    make dc_build
```
### 5. Up docker containers
```
    make dc_up
```
### 6. Go to php-container adn apply migrations
```
    php bin/console doctrine:migrations:migrate
```
### 7. Go to browser
The project must be up and work in [localhost](http://127.0.0.1/)