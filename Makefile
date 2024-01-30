up:
	docker-compose up --detach

down:
	docker-compose down

restart:
	make down up

install:
	docker-compose up --build --detach
	docker exec -it sorting_app composer install
	docker exec -it sorting_app npm install
	docker exec -it sorting_app npm run build

bash:
	docker exec -it sorting_app bash

test-unit:
	docker exec -it sorting_app php vendor/bin/phpunit --testsuite unit

test-integration:
	docker exec -it sorting_app php vendor/bin/phpunit --testsuite integration

test-e2e:
	docker exec -it sorting_app php vendor/bin/behat

format:
	docker exec -it sorting_app vendor/bin/php-cs-fixer fix src
	docker exec -it sorting_app vendor/bin/php-cs-fixer fix tests