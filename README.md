# Invoice-It

A Simple invoice management system built with Laravel 12, Inertia.js, and Vue 3. Manage clients, create invoices, and export them to PDF.

## Features

- **Client Management** - Create, edit, and manage client information
- **Invoice Generation** - Create detailed invoices with line items
- **PDF Export** - Export invoices to PDF format using Spatie Laravel PDF
- **Role-Based Access** - Super admin role for managing the system
- **Modern UI** - Built with Vue 3, Inertia.js, and Tailwind CSS

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Vue 3 + Inertia.js
- **Styling**: Tailwind CSS
- **PDF Generation**: Spatie Laravel PDF (Puppeteer)
- **Authentication**: Laravel Breeze

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/MohcinBN/invoice-it.git
cd invoice-it
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database setup

```bash
# Create SQLite database (or configure your preferred database in .env)
touch database/database.sqlite

# Run migrations
php artisan migrate
```

### 5. Run the application

**Option A: Using the dev script (recommended)**
```bash
composer dev
```
This runs the Laravel server, queue worker, logs, and Vite dev server concurrently.

**Option B: Manual setup**
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev

# Terminal 3 (optional): Start queue worker
php artisan queue:listen
```

### 6. Access the application

Open your browser and visit: `http://localhost:8000`

## Default User

After running seeders a super admin user will be created:

```bash
php artisan db:seed
```


Login with:
- Email: `superadmin@example.com`
- Password: `password`

ENJOY!