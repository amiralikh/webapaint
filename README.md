<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

this project develop by Laravel 10.5 , mySQL , php 8.1


it's just technical test project and authentication is not required but for middleware and basic authentication by default i use sanctum with passing just user_id (authentication is not very secure and because of that i dont use email and password).

there is a postman collection with name 'webapaint.postman' include response and request samples for endpoints.

## Installation
- clone project
- cp .env.example and rename as .env
- enter database connections details
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed` -- this step is optional only if you want seeding your database use it
