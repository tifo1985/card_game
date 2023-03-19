DOCKER_COMPOSE=@docker-compose $(COMPOSE_FILE_PATH)
COMPOSE_FILE_PATH := -f docker-compose.yml
DOCKER_EXEC_CMD=$(DOCKER_COMPOSE) exec

#- —— 🐳 Docker common services —————————————————————————————————————————————————————————
install: buildImage start vendorInstall

buildImage: #- Build the containers
	$(DOCKER_COMPOSE) build $(ARGUMENT)

start: #- Start the containers (only work when installed)
	$(DOCKER_COMPOSE) up -d $(ARGUMENT)

vendorInstall: #- Install the vendors
	$(DOCKER_EXEC_CMD) card_game-php composer install

#- —— ✨ Code style / Tests services —————————————————————————————————————————————————————————
php-cs-fixer: #- Check PHP Coding Standards Fixer.
	$(DOCKER_EXEC_CMD) card_game-php /bin/sh -c "vendor/bin/php-cs-fixer fix --using-cache=no --verbose --diff --dry-run"
apply-php-cs-fixer: #- Applying PHP Coding Standards Fixer.
	$(DOCKER_EXEC_CMD) card_game-php /bin/sh -c "vendor/bin/php-cs-fixer fix --using-cache=no --verbose"
unit-tests: #- Run unit tests.
	@$(DOCKER_EXEC_CMD) card_game-php /bin/sh -c "DEBUG_MODE=off APP_ENV=test vendor/bin/phpunit"
