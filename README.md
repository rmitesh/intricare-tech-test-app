## PHP Test

#### Requirement

- PHP v8.2.0 OR v8.3.0

### Installation

- Install composer dependuncy.
```bash
composer install
```

- Copy `.env` file

```bash
cp .env.example .env
```

- Generate Application Key

```bash
php artisan key:generate
```


- Create database in sqlite
```bash
touch database/database.sqlite
```
> You can use mysql drive, just change DB_CONNECTION `sqlite` to `mysql` and uncomment the DB variables and create `test_app` database

- Run migration
```bash
php artisan migrate
```

- Create symbolic link from the storage for the file upload.
```bash
php artisan storage:link
```
