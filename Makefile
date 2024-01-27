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
