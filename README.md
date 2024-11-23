# Expense Tracker

A comprehensive expense tracking application built with Laravel, TailwindCSS, and AlpineJS. The system features multi-role support, transaction management, and detailed expense analytics.

## Features

### Admin Dashboard

-   Total Users, Categories & Transaction Statistics
-   Category management and statistics

### User Features

-   Account management
-   Transaction tracking and categorization
-   Expense analytics with visual graphs
-   Flexible expense filtering (weekly/monthly/yearly)
-   Expense summaries and statistics
-   PDF report generation
-   Profile management

## Tech Stack

-   **Backend:** Laravel
-   **Frontend:** TailwindCSS, AlpineJS, Jquery
-   **Database:** MySQL/Sqlite
-   **Authentication:** Laravel's breeze

## Installation

1. Clone the repository

```bash
git clone https://github.com/theanupambista/expense-tracker
cd expense-tracker
```

2. Install PHP dependencies

```bash
composer install
```

3. Install and compile frontend dependencies

```bash
npm install
npm run build
```

4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database credentials in the `.env` file:
(can be used sqlite too)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Database Setup

```bash
php artisan migrate
```

6. (Optional) Seed the database

```bash
php artisan db:seed
```

This will create:

-   Two default users (admin and regular user)
-   Sample accounts
-   Default categories
-   Sample transactions

7. Start the development server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Users

After seeding the database, you can use these credentials:

**Admin User:**

-   Email: admin@gmail.com
-   Password: a1b2c3d4D!

**Regular User:**

-   Email: test@gmail.com
-   Password: a1b2c3d4D!
