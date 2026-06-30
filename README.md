# Laravel 12 Passport oauth Authentication API

A complete REST Authentication API built with Laravel 12 and Laravel Passport.

This project demonstrates how to build a professional authentication system using Repository Pattern, Service Layer, Dependency Injection, Form Requests, and Laravel Passport.

---

# Features

✔ User Registration

✔ User Login

✔ User Profile

✔ User Logout

✔ OAuth2 Authentication

✔ JWT Access Token

✔ Repository Pattern

✔ Service Layer

✔ Dependency Injection

✔ Form Request Validation

✔ REST API

✔ JSON Response

✔ Protected Routes

---

# Tech Stack

Laravel 12

PHP 8.2

Laravel Passport

MySQL

Postman

PHPUnit (for API Testing)

---

# Project Structure

app/

Http/

Controllers/

Requests/

Interfaces/

Repositories/

Services/

Models/

routes/

database/

tests/

---

# Architecture

Client

↓

API Routes

↓

Controller

↓

Service

↓

Repository

↓

Database

---

# Authentication Flow

Register

↓

Login

↓

Passport Access Token

↓

Protected APIs

↓

Profile

↓

Logout

---

# Installation

Clone Repository

```bash
git clone https://github.com/arvindxdevtech-hub/laravel12-oauth-passport-api.git
```

Move into Project

```bash
cd laravel12-passport-auth-api
```

Install Packages

```bash
composer install
```

Create Environment File

```bash
cp .env.example .env
```

Generate Application Key

```bash
php artisan key:generate
```

Configure Database

Update

```
DB_DATABASE

DB_USERNAME

DB_PASSWORD
```

Run Migration

```bash
php artisan migrate
```

Install Passport

```bash
php artisan install:api --passport
```

Generate Passport Keys

```bash
php artisan passport:keys
```

Create Personal Access Client

```bash
php artisan passport:client --personal
```

Start Server

```bash
php artisan serve
```

---

# API Endpoints

| Method | Endpoint      | Description   |
| ------ | ------------- | ------------- |
| POST   | /api/register | Register User |
| POST   | /api/login    | Login User    |
| GET    | /api/profile  | User Profile  |
| POST   | /api/logout   | Logout User   |

---

# API Testing

Tested using Postman.

Add the following headers.

Accept

```
application/json
```

Authorization

```
Bearer YOUR_ACCESS_TOKEN
```

---

# Register API

Method

POST

URL

```
/api/register
```

Body

```json
{
    "name": "Arvind",
    "email": "arvind@gmail.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}
```

Response

```
User Created

Access Token Generated
```

> 📸 **Add Screenshot:** `docs/screenshots/register-success.png`

---

# Login API

POST

```
/api/login
```

Response

```
JWT Token
```

> 📸 **Add Screenshot:** `docs/screenshots/login-success.png`

---

# Profile API

GET

```
/api/profile
```

Authorization

Bearer Token Required

> 📸 **Add Screenshot:** `docs/screenshots/profile-success.png`

---

# Logout API

POST

```
/api/logout
```

Bearer Token Required

> 📸 **Add Screenshot:** `docs/screenshots/logout-success.png`

---

# Validation

RegisterRequest

LoginRequest

---

# Design Pattern Used

Repository Pattern

Service Layer

Dependency Injection

Form Request Validation

---

# Database Tables

users

oauth_clients

oauth_access_tokens

oauth_refresh_tokens

oauth_auth_codes

oauth_device_codes

---

# Passport Commands

Install Passport

```bash
php artisan install:api --passport
```

Generate Keys

```bash
php artisan passport:keys
```

Create Personal Client

```bash
php artisan passport:client --personal
```

---

# Testing

Framework

PHPUnit

Run All Tests

```bash
php artisan test
```

Run Auth Tests

```bash
php artisan test --filter=AuthTest
```

---

# Future Improvements

Refresh Token

Password Grant

Authorization Code Grant

Scopes

Role Based Authentication

Email Verification

Forgot Password

API Rate Limiting

---

# Author

Arvind Singh Sisodia

Senior PHP / Laravel Developer
