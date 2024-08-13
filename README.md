# Survey Application

Laravel 11 + Vue.js + Tailwind

This project is a web-based survey application built with Laravel 11 + Vue.js + Tailwind. It allows you to create, manage, and distribute surveys for people to answer. Additionally, this project integrates with Jira to streamline issue tracking and project management.


## to do >___<

* front end : Vue.js + Tailwind

* laravel testing


## Laravel Getting Started

To build and run this project, follow the steps below:

1. **Set up your environment variables:**

    - Copy the `.env.example` file to `.env`:

      ```bash
      cp .env.example .env
      ```

    - Configure your database connection in the `.env` file:

      ```dotenv
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=your_database_name
      DB_USERNAME=your_database_user
      DB_PASSWORD=your_database_password
      ```

2. **Run database migrations:**

    - Migrate the database to set up the necessary tables:

      ```bash
      php artisan migrate
      ```

3. **Serve the application:**

    - Start the Laravel development server:

      ```bash
      php artisan serve
      ```

4. **Create a symbolic link for storage:**

    - This command will create a symbolic link from `public/storage` to `storage/app/public`, making your files accessible from the web:

      ```bash
      php artisan storage:link
      ```
