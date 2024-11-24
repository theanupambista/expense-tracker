# Expense Tracker

A comprehensive expense tracking application built with Laravel, TailwindCSS, and AlpineJS. The system features multi-role support, transaction management, and detailed expense analytics.

## Preview
[Watch this video on YouTube](https://www.youtube.com/embed/GCgj7VJGpMo)

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

# Expense Tracker API Documentation

## Overview

This documentation covers the expenses summary API endpoints of the Expense Tracker application. The API requires authentication, and all requests must include a valid authentication token.

## Authentication

### Login

Before accessing any expense endpoints, you must obtain an authentication token.

```
POST /api/login
```

#### Request Body

```json
{
    "email": "test@gmail.com",
    "password": "a1b2c3d4D!"
}
```

#### Response

```json
{
    "access_token": "4|HorR6qd23XT4chbRr93JnzQYhbaTrrE95TUsrV6G825ebd9e",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "name": "Testing Account",
        "email": "test@gmail.com",
        "email_verified_at": null,
        "created_at": null,
        "updated_at": null,
        "role": "user",
        "currency": "Rs."
    },
    "status": "Login successful"
}
```

## Expense Summary Endpoints

### Get Expense Summary

Retrieve a summary of expenses based on specified filters.

```
GET /api/transactions/summary
```

#### Headers

```
Authorization: Bearer {your_token}
Accept: application/json
```

#### Query Parameters

-   `range` (string, optional): Filter by 'weekly', 'monthly', or 'yearly'
-   `date` (date, optional): Base date for custom range (format: YYYY-MM-DD)

#### Sample Response

```json
{
    "success": true,
    "data": [
        {
            "category": "Rent",
            "total_amount": 1381,
            "transaction_count": 1
        },
        {
            "category": "Food",
            "total_amount": 749,
            "transaction_count": 15
        },
        {
            "category": "Transporation",
            "total_amount": 620,
            "transaction_count": 12
        },
        {
            "category": "Insurance",
            "total_amount": 576,
            "transaction_count": 13
        },
        {
            "category": "Clothing",
            "total_amount": 523,
            "transaction_count": 10
        },
        {
            "category": "Health",
            "total_amount": 458,
            "transaction_count": 9
        },
        {
            "category": "Entertainment",
            "total_amount": 343,
            "transaction_count": 6
        },
        {
            "category": "Bills",
            "total_amount": 179,
            "transaction_count": 1
        },
        {
            "category": "Education",
            "total_amount": 14,
            "transaction_count": 1
        }
    ]
}
```

## Testing with Postman

### Setup Instructions

1. Import the Collection

    - Open Postman
    - Click on "Import" button
    - Select or drag the file: `api/expense-tracker.postman_collection.json`

2. Run the Collection
    - The collection is configured to:
        1. Execute the login request first
        2. Automatically set the received token for subsequent requests
        3. Run the expense summary requests with various filters

### Example Requests

1. Weekly Summary

```
GET {{base_url}}/transactions/summary?range=weekly
```

2. Monthly Summary with Category Filter

```
GET {{base_url}}/transactions/summary?range=monthly&date=2024-10-12
```

## Error Responses

### Authentication Errors

```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

### Validation Errors

```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "period": ["The period must be one of: weekly, monthly, yearly"],
        "start_date": ["The start date must be a valid date"]
    }
}
```
