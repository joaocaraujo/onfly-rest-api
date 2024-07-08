## Running the Project

To get the project up and running with Docker, follow these simple steps:

1. **Build the Docker Container**: First, you need to build the Docker container for the project. Open your terminal, navigate to the project directory, and run the following command:
   ```sh
   docker-compose up --build

2. **Accessing the Application**: Once the Docker containers are up and running, you can access the Laravel application by visiting http://localhost:8080 in your web browser. This is the default port that the Laravel application runs on when using Docker.

3. **Running Database Migrations**: To set up your database with the necessary tables and data, you'll need to run the Laravel migrations. You can do this by executing the following command:
   ```sh
   php artisan migrate

## API Routes

This project uses Laravel's resource routing to handle API requests, with custom routes for user authentication and resource routes for `expenses`. Below are the basic routes available, including the HTTP verbs and the corresponding actions.

### User Authentication Routes

- **Register**: `POST /api/register`
  - Registers a new user.
  - **Body**:
    ```json
    {
      "name": "name",
      "email": "example@example.com",
      "password": "123456",
      "password_confirmation": "123456"
    }
    ```
- **Login**: `POST /api/login`
  - Authenticates the user and returns a token.
  - **Body**:
    ```json
    {
      "email": "example@example.com",
      "password": "123456"
    }
    ```
- **Logout**: `POST /api/logout`
  - Logs out the user by invalidating the token.
  - **Authentication**: Bearer Token

### Expenses Routes

- **List all expenses**: `GET /api/expenses`
  - Retrieves a list of all expenses.
  - **Authentication**: Bearer Token

- **Create a new expense**: `POST /api/expenses`
  - Creates a new expense with the provided data.
  - **Authentication**: Bearer Token
  - **Body**:
    ```json
    {
      "description": "example",
      "value": 100.99,
      "date": "2024-04-30"
    }
    ```

- **Show a specific expense**: `GET /api/expenses/{id}`
  - Retrieves the details of a specific expense.
  - **Authentication**: Bearer Token

- **Update an expense**: `PUT/PATCH /api/expenses/{id}`
  - Updates the specified expense with the provided data.
  - **Authentication**: Bearer Token
  - **Body**:
    ```json
    {
      "description": "new example",
      "value": 1.55,
      "date": "2024-01-05"
    }
    ```

- **Delete an expense**: `DELETE /api/expenses/{id}`
  - Deletes the specified expense.
  - **Authentication**: Bearer Token

## Email Simulation with MailHog

For this project, we've integrated MailHog to simulate the email sending process. This is particularly useful for testing email notifications received by users upon registering or creating a new expense, without the need to set up a real email server.

### Accessing MailHog

To view the emails sent by the application, you can access the MailHog web interface by visiting:

- **MailHog Web Interface**: [http://localhost:8025/#](http://localhost:8025/#)

MailHog runs on port 8025 by default, and you can use this interface to review all emails sent during your testing process.