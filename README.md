## Yaraku Libreria App

Uses Laravel and VueJs. Allows you to store book names associated with their authors.

## Installation
```bash
composer install
cp .env.example .env
php artisan key:generate 
```

Connect your database and set your access credentials in `.env` file and update config cache:
```bash
php artisan config:cache
```

Install npm modules and generate assets:
```bash
npm install
npm run production
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

Note: in case of receiving error:
> Test directory "<..>./tests/Unit" not found

run:
```bash
mkdir tests/Unit
```
