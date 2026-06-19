<<<<<<< HEAD
# Oakridge School Library System (Laravel + Herd)

A full-stack library management system: catalog search, student self-checkout,
holds/reservations, overdue tracking with fines, and librarian reports.

This is a Laravel 11 rebuild of the original Node.js version, built for
**[Laravel Herd](https://herd.laravel.com)** with MySQL.

## What's inside

- **Backend:** Laravel 11 (PHP 8.2+)
- **Database:** MySQL (via Herd's bundled MySQL service)
- **Auth:** custom session-based login (own controller + views, Laravel's `Auth` facade underneath)
- **Frontend:** Blade + Livewire 3 (interactive, no separate JS build step)
- **Styling:** plain CSS, no Tailwind/build pipeline — same design system as the original

Demo data: **5,200 books**, 2 staff accounts, 40 student accounts, and a mix of
active/overdue checkouts and holds so reports have something to show.

## A note on how this was built

I don't have Composer or access to packagist.org in my working environment, so I
wasn't able to run `composer install` or boot-test this the way I could with the
Node.js version. Every PHP file has been syntax-checked with `php -l`, and I've
traced through the routing, model bindings, and Livewire wiring carefully — but
**you'll be the one running this for the first time**. If something doesn't boot,
the error message Laravel/Herd gives you will be the fastest way to track it down,
and I'm glad to help debug from there.

## Setup with Herd

### 1. Get the project into place

Unzip this project somewhere Herd can see it — typically `~/Herd` or wherever
you've configured Herd's sites path. Then, from Herd's app or terminal:

```bash
cd oakridge-library
composer install
```

This pulls in Laravel, Livewire, and the other dependencies listed in `composer.json`.

### 2. Set up your `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Herd's bundled MySQL listens on `127.0.0.1:3306` with username `root` and an
empty password by default. The `.env.example` is already set up for that. If
you've customized Herd's MySQL credentials, update `DB_USERNAME`/`DB_PASSWORD`
in `.env` to match.

### 3. Create the database

Using Herd's MySQL (via the Herd UI's "Database" tab, or the `mysql` CLI):

```sql
CREATE DATABASE oakridge_library;
```

Make sure `DB_DATABASE` in `.env` matches whatever you name it.

### 4. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
```

The seeders are idempotent — they check if data already exists and skip if so,
so re-running `db:seed` won't duplicate anything.

### 5. Point Herd at the site

Herd auto-detects Laravel projects in its configured sites directory and serves
them at `http://<folder-name>.test`. If your folder is named `oakridge-library`,
that's `http://oakridge-library.test`. Update `APP_URL` in `.env` to match
whatever hostname Herd assigns.

If you'd rather run it manually without Herd's auto-detection:

```bash
php artisan serve
```

and visit `http://localhost:8000`.

### Demo logins

| Role    | Username    | Password     |
|---------|-------------|--------------|
| Admin   | `admin`     | `admin123`   |
| Admin   | `libstaff`  | `staff123`   |
| Student | `student1`  | `student123` |
| Student | `student2` … `student40` | `student123` |

## Features

**Students can:**
- Search/filter the catalog by title, author, genre, ISBN, or call number
- Check out available books (5-book limit) and see due dates
- Renew a checkout (if no one else is waiting on a hold)
- Return books — fines calculate automatically at 25¢/day late
- Place a hold on a book that's fully checked out, and cancel it later
- See their current checkouts, due dates, and return history

**Admins/librarians can:**
- See a dashboard of total titles, copies, active checkouts, overdue count, and holds
- View every active checkout and mark any of them returned
- View the full holds queue
- Add new books to the catalog
- Run reports: overdue list (with estimated fines), most-borrowed titles, inventory by genre

**Circulation rules baked in:**
- 14-day loan period
- 25¢/day late fee, calculated on return
- 5 active checkouts per student
- Returning a book automatically marks the next hold in line as "ready"
- Database-level row locking on checkout/return to avoid race conditions
  (two students can't both grab the "last copy" at the same instant)

## Project structure

```
app/
  Models/              # User, Book, Checkout, Hold (Eloquent)
  Services/
    CirculationService.php   # All checkout/return/renew/hold business logic
  Exceptions/
    CirculationException.php # User-facing circulation rule violations
  Http/
    Controllers/
      AuthController.php         # Custom login/logout
      DashboardController.php    # Routes admin vs student to the right view
      AdminDashboardController.php
    Middleware/
      EnsureUserIsAuthenticated.php
      EnsureUserIsAdmin.php
  Livewire/
    Catalog.php          # Search/filter/paginate
    BookDetail.php        # Checkout / place hold
    MyBooks.php            # Student's active checkouts + return/renew
    MyHolds.php             # Student's holds + cancel
    Admin/
      ActiveCheckouts.php   # All active checkouts, mark returned
      HoldsQueue.php        # Holds queue view
      Reports.php           # Overdue / most-borrowed / inventory reports
      AddBook.php           # Add-book form
database/
  migrations/            # users, books, checkouts, holds, + Laravel framework tables
  seeders/               # Demo data generators (idempotent)
resources/views/
  layouts/ + components/app-layout.blade.php   # Sidebar shell
  auth/login.blade.php
  admin/dashboard.blade.php
  livewire/              # One view per Livewire component
  vendor/pagination/custom.blade.php   # Styled pagination (replaces Tailwind default)
public/css/style.css      # Design system — parchment/forest-green/stamp motif
config/library.php        # Circulation rule constants (loan days, fine rate, max checkouts)
```

## Customizing circulation rules

All the circulation constants live in `config/library.php`, and can be overridden
via `.env` without touching code:

```env
LIBRARY_LOAN_DAYS=14
LIBRARY_FINE_CENTS_PER_DAY=25
LIBRARY_MAX_CHECKOUTS_PER_STUDENT=5
```

## Before deploying to a real school server

This is a working demo, not yet production-hardened. Before deploying for real:

1. **Set `APP_ENV=production` and `APP_DEBUG=false`** in `.env` — debug mode
   leaks stack traces to visitors.
2. **Generate a real `APP_KEY`** via `php artisan key:generate` on the
   production server (don't reuse a dev key).
3. **Use HTTPS.** Put this behind a reverse proxy with a TLS certificate if
   Herd isn't your production environment (Herd is a local dev tool).
4. **Real accounts.** Replace the demo seed accounts with real student/staff
   records, ideally synced from whatever student information system (SIS)
   the school already uses.
5. **Backups.** Set up regular automated MySQL backups.
6. **Run migrations only — don't re-seed** on a production database that
   already has real data; the seeders are meant for fresh demo setups.
=======
# SMK-ABC-Library-System
A full-stack school library management system built with Laravel &amp; Livewire — catalog search, student checkout/holds, overdue tracking, and librarian reports for SMK ABC.
>>>>>>> f35d3dbd7c6c5682f5cfba941ffd0b35b0836ec6
