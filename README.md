## Version

| PHP     | Laravel | MySQL    | Node    |
|:-------:|:-------:|:--------:|:-------:|
| 8.1     | 9       | 8.0      | 16      |

## How to use

1. `$ cd laravel_9`
2. `$ mkdir src`
3. `$ docker compose up -d`
4. `$ docker compose exec app composer create-project --prefer-dist 'laravel/laravel=9.*' .`
5. `$ docker compose exec app php artisan storage:link`
6. `$ docker compose exec app php artisan migrate:fresh --seed`
