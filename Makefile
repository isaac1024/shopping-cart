default: help
help: ## Show makefile help
	@echo -e "Makefile help"
	@grep ": ##" $(MAKEFILE_LIST) | grep -v '@grep' | sed 's/ ##//' | awk -F: '{print "  \033[1m"$$1":\033[0m"$$2}'

up: ## Up docker containers
	@cp -n .env.example .env || true
	@docker-compose up -d

down: ## Down docker containers
	@docker-compose down

prepare: ## Prepare database
	@cp -n api/.env.example api/.env || true
	@cp -n api/.env.test.example api/.env.test || true
	@docker-compose exec api composer install
	@docker-compose exec api php bin/console doctrine:migrations:migrate -n
	@docker-compose exec api php bin/console doctrine:database:create --if-not-exists -e test
	@docker-compose exec api php bin/console doctrine:migrations:migrate -n -e test

lint: ## Run linters
	@docker-compose exec api composer lint

test: ## Run tests
	@docker-compose exec api composer test

mutant: ## Run mutant testing
	@docker-compose exec api infection