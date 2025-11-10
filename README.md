# Laravel 11

## How to start the project using Docker

1. Install Docker on your local machine.

2. Run:
   ```bash
   cp ./.env.example ./.env
   ```

3. Run:
   ```bash
   docker compose up --build -d
   ```

4. Run:
   ```bash
   mkdir -p storage/framework/sessions
   mkdir -p storage/framework/views
   mkdir -p storage/framework/cache
   ```
5. Run:
   ```bash
   chmod -R 777 ./storage
   ```
6. Run:
   ```bash
     composer install 
   ```
7. Run:
   ```bash
   docker compose exec app php artisan migrate:fresh --seed
   ```
8. Run:
   ```bash
   docker compose exec app php artisan optimize:clear
   ```
9. Run:
   ```bash
     php artisan key:generate  
   ```

10.Visit http://localhost:8000
