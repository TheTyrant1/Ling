<p align="center">
    <img src="public/assets/readme/images/logo/logo.svg" width="100" alt="Ling"/>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-13.15.0-red" alt="Laravel">
    <img src="https://img.shields.io/github/v/release/TheTyrant1/Ling" alt="Laravel">
    <img src="https://img.shields.io/badge/License-Apache%202.0-purple" alt="License">
</p>

<p align="center">
    Modern open-source social platform built with Laravel.
</p>

## Features

### Authentication
- User authentication and authorization
- Email verification

### Social system
- Posts and comments
- Following system
- User profiles

### Activity
- User history
- Notifications
- Appeals system

### Panels
- User dashboard
- Admin dashboard

## Stack

### Backend
- [PHP](https://www.php.net/)
- [PostgreSQL](https://www.postgresql.org/)
- [Laravel](https://laravel.com/)

### Frontend
- HTML [(Blade)](https://laravel.com/docs/13.x/blade)
- CSS [(SCSS)](https://sass-lang.com/)
- JS

## Get started
To run the project locally, follow these steps:

### 1. Clone my repository locally

```bash
git clone https://github.com/TheTyrant1/Ling.git
```
Go to directory

```bash
cd Ling
```

### 2. Install dependencies
Install PHP and Node.js dependencies:
```bash
composer install
```

```bash
npm install
```

### 3. Create .env from .env.example
In `Windows`
```cmd
copy .env.example .env
```

In `Linux // MacOS`
```bash
cp .env.example .env
```

Generate APP_KEY in .env
```bash
php artisan key:generate
```

### 4. Database Setup
Open `.env` file and choose one of the two options:

#### Variant 1 (Fast test start)
Ensure that your `DB_` section looks like
```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

Run this command, and Laravel will create the `database.sqlite` file with the table schemas:
```bash
php artisan migrate
```
Also, if you want, you can create test data `(users, posts, comments)`
```bash
php artisan db:seed
```
If you need to completely wipe the database and recreate all tables from scratch, use the command below.
>Do not run this on production, as it deletes all data permanently!
```bash
php artisan migrate:fresh
```

#### Variant 2 (Main // Recommended)

*If you don't have `PostgreSQL` download from [here](https://www.postgresql.org/download/)*
1. Open your database manager ([pgAdmin](https://www.pgadmin.org/download/), [DBeaver](https://dbeaver.io/download/), etc.)
2. Create new empty database with user for this project (example, `laravel_your_project_db`)
3. Ensure that your `DB_` section looks like

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel_your_project_db
DB_USERNAME=name_your_user
DB_PASSWORD=password_your_user
```
Run this command, and Laravel will create the table schemas:
```bash
php artisan migrate
```

Also, if you want, you can create test data `(users, posts, comments)`
```bash
php artisan db:seed
```
If you need to completely wipe the database and recreate all tables from scratch, use the command below.
>Do not run this on production, as it deletes all data permanently!
```bash
php artisan migrate:fresh
```

### 5. Create Storage Symbolic Link
Run this command if you executed seeders in the previous step and are not using cloud storage integration:

```bash
php artisan storage:link
```

### 6. Final commands
Fast start
```bash
npm run dev:full
```

Or, If you want to run all commands manually in each terminal window, next stage:


Start `php` local server

```bash
php artisan serve
```

Start `php queue`
```bash
php artisan queue:work
```

Start `php scheduler`
```bash
php artisan schedule:work
```
Start `npm`
```bash
npm run dev
```

## License

Ling is open-sourced software licensed under the [Apache 2.0 license](https://www.apache.org/licenses/LICENSE-2.0).
