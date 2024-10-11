# User API Project

This project is a simple JSON API built with Laravel to manage user data. The API supports operations like creating and retrieving user information, and returns the responses in camelCase format. It also validates user inputs, such as user names and country codes, against predefined rules.

## Installation

### Prerequisites

- **PHP 8.x**
- **Composer**
- **Docker** (optional, if you prefer running MySQL in Docker)
- **MySQL** (if using a local or external MySQL server)

1. Clone the repository:
   ```bash
   git clone https://github.com/jborunov/user-api.git
   ```

2. Navigate into the project directory:
   ```bash
   cd user-api
   ```

3. Install the dependencies:
   ```bash
   composer install
   ```

4. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

5. Update the .env file with your MySQL database credentials

6. Set up your database in the `.env` file and run migrations:
   ```bash
   php artisan migrate
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```



## API Endpoints

### Create User
- **URL:** `POST /api/users`
- **Description:** Create a new user.
- **Request Body:**
  ```json
  {
      "firstName": "John",
      "lastName": "Doe",
      "userName": "johndoe",
      "countryCode": "US",
      "ipAddress": "192.168.1.1"
  }
  ```
- **Response:**
  ```json
  {
      "firstName": "John",
      "lastName": "Doe",
      "userName": "johndoe",
      "countryName": "United States",
      "ipAddressSum": 362
  }
  ```

### List Users
- **URL:** `GET /api/users`
- **Description:** Retrieve a list of all users.
- **Response:**
  ```json
  [
      {
          "firstName": "John",
          "lastName": "Doe",
          "userName": "johndoe",
          "countryName": "United States",
          "ipAddressSum": 362
      },
      {
          "firstName": "Jane",
          "lastName": "Smith",
          "userName": "janesmith",
          "countryName": "Canada",
          "ipAddressSum": 366
      }
  ]
  ```

## Validation Rules

- `userName`: Required, must be unique, and can only contain letters (no spaces or numbers).
- `countryCode`: Required, must be a valid 2-letter country code from the config file.
- `ipAddress`: Optional, must be a valid IPv4 address.

## Technologies Used

- Laravel 10.x
- MySQL
- PHP 8.x

## Possible Improvements

- Include authentification 
- Store some mathimatical operations (ipAddressSum) results in the DB to avoid using memory
- Paginations for the users request, to avoid large data bottlenecks
- Include more Unit testing
- ...