#!/bin/bash

if [ -f "backend/.env" ]; then
    echo "A .env fájl már létezik"
else
    cp backend/.env.example backend/.env
fi

if [ -f ".env" ]; then
    echo "A .env fájl már létezik"
else
    ln -s backend/.env
fi

if [ -f "backend/.env.testing" ]; then
    echo "A .env.testing fájl már létezik"
else
    cp backend/.env.testing backend/.env.testing
fi

if [ -f ".env.testing" ]; then
    echo "A .env.testing fájl már létezik"
else
    ln -s backend/.env.testing
fi

docker run --rm  -v "$(pwd)/frontend:/app" --entrypoint npm idomi27/vue install

docker compose up -d

docker compose exec backend composer install

docker compose exec backend php artisan migrate:fresh --seed

docker compose exec backend php artisan route:list --except-vendor

docker compose exec backend php artisan storage:link

if [ -z "${APP_KEY}" ]; then
    docker compose exec backend php artisan key:generate
else
    echo "Az API kulcs már létezik" 
fi