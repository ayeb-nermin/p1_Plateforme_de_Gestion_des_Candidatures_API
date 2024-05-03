
## Requirements
 - PHP >= 8.0
 - BCMath PHP Extension
 - Ctype PHP Extension
 - Fileinfo PHP Extension
 - JSON PHP Extension
 - Mbstring PHP Extension
 - OpenSSL PHP Extension
 - PDO PHP Extension
 - Tokenizer PHP Extension
 - XML PHP Extension

## Installation   
1. Copy `.env.example` to `.env`
2. In the `.env` file, set up database config
```bash
    - DB_CONNECTION=pgsql
    - DB_HOST = 127.0.0.1
    - DB_PORT = 3306
    - DB_DATABASE = database_name
    - DB_USERNAME = username
    - DB_PASSWORD = *******
```
3. Execute `composer install`
4. Execute `php artisan key:generate`
5. Migrate the database with `php artisan migrate`
6. Execute `php artisan passport:install`
    - 6.1 Execute `php artisan passport:client --personal --name laravel_personal_access_api_users`
    - 6.2 Execute `php artisan passport:client --password --name passsword_grant_client --provider api_users_provider`
    - 6.3 Execute `php artisan passport:client --personal --name laravel_personal_access_app_users`
    - 6.4 Execute `php artisan passport:client --password --name passsword_grant_client --provider app_users_provider`

## Swagger

To generate the new docs of swagger after changing it, you should run

```bash
php artisan l5-swagger:generate
```

## Log Viewer

To modify the login and password of log viewer you can edit them in your .env file

```bash
# LogViewer
LOGVIEWER_USERNAME="logViewer@endpoint.com"
LOGVIEWER_PASSWORD="logViewerEndpoint@2024"
```


## laravel verion:

-   Laravel Framework 10.10
