To start:

```sh
docker-compose up
```

For the first time, please run the following to initialize the database

```sh
docker-compose run web-app php artisan migrate
```

Notes: port 80 will be exposed
