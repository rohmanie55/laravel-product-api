# Laravel JWT API Application

This is a Laravel application with JWT authentication and API capabilities.

## Requirements

- PHP >= 8.0
- Laravel >= 9.0
- Composer
- MySQL or other relational database

## Installation

1. Clone this repository to your local machine:
git clone https://github.com/rohmanie55/laravel-product-api.git

2. Change directory into the cloned repository:
cd laravel-product-api

3. Install dependencies:
composer install

4. Copy the `.env.example` file to `.env` and modify the database and other configuration settings as necessary.

5. Generate an application key:
php artisan key:generate

6. Create a database and update the `.env` file with the database name, username, and password.

7. Run database migrations:
php artisan migrate

8. Seed the database (optional):
php artisan db:seed

## Running the Application

1. Start a development server:
php artisan serve

2. Visit the URL in your browser: `http://localhost:8000`

## API Endpoints

The API endpoints are located at `/api/v1` and are protected by JWT authentication. To get started, you'll need to obtain a JWT token by making a `POST` request to `/api/v1/login` with your credentials. Then, include the token in the `Authorization` header of subsequent requests to the API.

### Login
- `POST api/v1/login`: Log in and receive a JWT token.

### Logout
- `POST api/v1/logout`: Log out and invalidate the JWT token.

### Category
- `GET|HEAD api/v1/category`: Retrieve a list of categories. Requires a JWT token.
- `POST api/v1/category`: Create a new category. Requires a JWT token.
- `PUT|PATCH api/v1/category/{category}`: Update an existing category. Requires a JWT token.
- `DELETE api/v1/category/{category}`: Delete a category. Requires a JWT token.

### Image
- `GET|HEAD api/v1/image`: Retrieve a list of images. Requires a JWT token.
- `POST api/v1/image`: Upload a new image. Requires a JWT token.
- `PUT|PATCH api/v1/image/{image}`: Update an existing image. Requires a JWT token.
- `DELETE api/v1/image/{image}`: Delete an image. Requires a JWT token.

### Product
- `GET|HEAD api/v1/product`: Retrieve a list of products. Requires a JWT token.
- `POST api/v1/product`: Create a new product. Requires a JWT token.
- `PUT|PATCH api/v1/product/{product}`: Update an existing product. Requires a JWT token.
- `DELETE api/v1/product/{product}`: Delete a product. Requires a JWT token.
