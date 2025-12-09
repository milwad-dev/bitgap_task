build:
	docker-compose up --build -d

up:
	docker-compose up -d

down:
	docker-compose down

migrate:
	docker-compose exec -it app php artisan migrate

