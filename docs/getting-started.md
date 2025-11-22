# Getting Started

This guide will walk you through setting up the Newlife Website project on your local development machine.

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- A database server (e.g., MySQL, PostgreSQL)

## Installation

1.  **Clone the repository:**

    ```bash
    git clone <repository-url>
    cd newlife-website
    ```

2.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

4.  **Create your environment file:**

    If it doesn't exist, copy the `.env.example` file to a new file named `.env`.

    ```bash
    copy .env.example .env
    ```

    *Note: If `.env.example` does not exist, you will need to create `.env` manually and configure it based on a standard Laravel setup.*

5.  **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

6.  **Configure your database:**

    Open the `.env` file and update the `DB_*` variables with your database credentials.

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=newlife
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Run database migrations:**

    This will create all the necessary tables in your database.

    ```bash
    php artisan migrate
    ```

8.  **Seed the database (optional):**

    This will populate the database with initial data.

    ```bash
    php artisan db:seed
    ```

9.  **Build frontend assets:**

    ```bash
    npm run dev
    ```

10. **Run the development server:**

    ```bash
    php artisan serve
    ```

The application should now be running at `http://127.0.0.1:8000`.

## Admin Panel

The admin panel is built with Filament. You can access it at `/admin`. To create an admin user, you can run the `UserAdminSeeder` or create a new user and grant them the necessary permissions.
