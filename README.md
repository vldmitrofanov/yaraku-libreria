## Yaraku Libreria App

Uses Laravel and VueJs. Allows you to store book names associated with their authors.

## Installation
```bash
composer install
php artisan key:generate 
cp example.env to .env
```

Connect your database and set your access credentials in `.env` file and update config cache:
```bash
php artisan config:cache
```

Once database connection is ready run migration:
```bash
php artisan migrate
```

To generate some fake data run:
```bash
php artisan fake:books 500
```

To test run:
```bash
php artisan test
```