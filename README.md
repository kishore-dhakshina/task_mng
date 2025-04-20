Task Management System API

Overview

This project is a RESTful API for a Task Management System, built with PHP, Laravel 11, and JWT-based authentication. The system allows users to manage tasks and categories, with role-based access control (Admin/User). The API is designed following best practices for RESTful API design, database normalization, and OOP principles.


Table of Contents

    Technologies Used

    Database Setup

    Installation Instructions

    API Endpoints

        User Endpoints

        Task Endpoints

        Category Endpoints

    Authentication

    Error Handling


    Technologies Used

    PHP 8.x

    Laravel 11

    JWT (JSON Web Tokens) for authentication

    MySQL for the database

    Database Setup

    open .env and configure your database credentials:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=task_mng
    DB_USERNAME=root
    DB_PASSWORD=

    Run the migration to set up the database:

    php artisan migrate


API Endpoints

User Endpoints

    POST /api/register
    Register a new user.

        Request body:
        {
            "name": "kishore",
            "email": "test@gmail.com",
            "password": "123456789"
        }


Authentication

    The API uses JWT (JSON Web Tokens) for user authentication. To authenticate a user, send a POST request to /api/login with the user credentials. Upon successful authentication, a JWT token will be returned, which must be included in the Authorization header for subsequent requests.

Example:
    Authorization: Bearer {your_jwt_token}


Error Handling

    The API uses standard HTTP status codes for error handling:

    201 Created for resource creation.

    400 Bad Request for invalid input or parameters.

    401 Unauthorized for missing or invalid JWT.

    403 Forbidden for access denied based on user roles.

    404 Not Found for missing resources.

    500 Internal Server Error for unexpected errors.