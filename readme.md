<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Runing SMBeez Application

- Install [WAMP](http://www.wampserver.com/en/) Server for PC or [MAMP](https://www.mamp.info/en/downloads/) for mac
- [Install Composer (if it's not installed on your PC/Mac)](https://getcomposer.org/).
- Open the terminal CMD and get sure that it is on the same directory of the files and type composer install
- Go to localhost/phpmyadmin and login with root and no password (if any error get sure that wamp/mamp is on)
- Create a database with charset utf8mb4 -- UTF-8 Unicode and collation utf8mb4_general_ci and Upload the sql file in the repo
- Rename the file called .env.example to .env (found in the main files directory)
- Set APP_NAME = SMBeez ,  DB_DATABASE= the name of database u created , DB_USERNAME=root, DB_PASSWORD= (leave empty for password)
- In the terminal run php artisan serve
- Go to [this page](http://localhost:8000/companies/all)
- SignIn with superadmin@app.com | password=password