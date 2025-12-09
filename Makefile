build:
	docker-compose down
	docker-compose up --build -d

up:
	docker-compose down
	docker-compose up -d

down:
	docker-compose down

migrate:
	docker-compose exec -it app php artisan migrate

seed:
	docker-compose exec -it app php artisan db:seed
