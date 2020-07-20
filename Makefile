# Makefile for Docker Nginx PHP Composer MySQL

include .env

# MySQL
MYSQL_DUMPS_DIR=data/db/dumps

#########################
######## Spin up ########
#########################

dev: init
	@docker-compose up -d
	@make logs

nodev:
	@docker-compose down -v
	@make clean

restart:
	@make nodev
	@make dev

rebuild:
	@docker-compose up -d --no-deps --build
	@make logs

logs:
	@docker-compose logs -f

#########################
### Inside containers ###
#########################

enter-code:
	@docker exec -it $(shell docker ps --format "{{.Names}}" --filter "name=be_php") bash

enter-nginix:
	@docker exec -it $(shell docker ps --format "{{.Names}}" --filter "name=be_nginix") sh

composer-up:
	@docker run --rm -v $(shell pwd)/api:/app composer update

composer-install:
	@docker run --rm -v $(shell pwd)/api:/app composer install

composer-require:
	@docker run --rm -v $(shell pwd)/api:/app composer require $(arg)

composer-remove:
	@docker run --rm -v $(shell pwd)/api:/app composer remove $(arg)

#########################
######## Others #########
#########################

remove-db:
	@rm -Rf data/db/mysql/*
	@rm -Rf $(MYSQL_DUMPS_DIR)/*

.PHONY: clean test code-sniff init
