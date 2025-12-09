# Bitgap Task

This project is a Laravel-based application built as part of a technical assignment.  
It demonstrates clean architecture, API design, SOLID principles, testing structure, and modern Laravel development practices.

---

## 🚀 Features

- Dockerized environment  
- Environment-based configuration  
- PestPHP tests included  
- Authentication
- Task Management with check roles
- Role-Permission system
- Cache with Redis
- Swagger
- Tests CI
- Laravel Pint
- PHPStan

---

## 📦 Requirements

- PHP 8.3
- Composer  
- PostgreSQL  
- Docker (optional)  

---

## 🛠 Installation

Clone the repository:

```bash
git clone https://github.com/milwad-dev/bitgap_task.git
cd bitgap_task
````

Install dependencies:

```bash
composer install
```

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Update your `.env` file and then run migrations:

```bash
php artisan migrate --seed
```

---

## 🐳 Running with Docker

Start the application using Docker:

```bash
make build
```

The app will be available at:

```
http://localhost:8000
```

After building, you can up containers with this command:

```bash
make up
```

If you may down containers, you can use this command:

```bash
make down
```

---

## 📘 API Documentation (Swagger)

This project provides Swagger documentation, which helps you explore API endpoints, request/response structures, and overall functionality.

### 🚀 Accessing Swagger UI

After running the service, Swagger UI can be accessed at:

```bash
http://localhost:8080/api/swagger
```

> The Swagger documentation is automatically generated from your code annotations, so it always stays up-to-date with the implemented endpoints.

---

## 🧪 Running Tests

Run the automated test suite:

```bash
composer test
composer test-coverage
```

---

## 📁 Project Structure

```txt
app/
├── Http/
├── Models/
├── ...
routes/
tests/
docker/
```

### Key Folders

* **app/Http/Controllers** — business logic layer
* **routes/** — API route definitions
* **tests/** — unit & feature tests
* **docker/** — Docker configuration files

---
