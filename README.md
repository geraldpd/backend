# Laravel REST API with OAuth2 Authentication

## Overview

This project is a Laravel-based API application with OAuth2 authentication using Laravel Passport and API documentation using APIDoc.

## Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js and npm
-   Docker for larave Sail

## Installation

### Clone the Repository

````bash
git clone https://github.com/geraldpd/backend.git
cd backend
````

### Starting Docker Sail
````bash
sail up
````

### Install composer and npm dependencies

```bash
composer install
npm install
````

To generate passport client

```bash
sail php artisan passport:client --personal
````

then run

```bash
sail php artisan config:clear
sail php artisan cache:clear
````



