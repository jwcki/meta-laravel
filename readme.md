TO init:
```sh
composer install 
```

To start:

```sh
docker-compose up
```

After first time start, please run:

```sh
docker-compose run web-app php artisan migrate
```

Notes: port 80 will be exposed
