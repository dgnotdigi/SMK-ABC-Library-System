# SMK ABC Library System

A full-stack library management system for SMK ABC: catalog search, student self-checkout,
holds/reservations, overdue tracking with fines, and librarian reports.

Built with Laravel 11 and Livewire. Runs on **Laravel Herd** (macOS) or **Laragon** (Windows).

## What's inside

- **Backend:** Laravel 11 (PHP 8.2+)
- **Database:** MySQL
- **Auth:** custom session-based login (own controller + views, Laravel's `Auth` facade underneath)
- **Frontend:** Blade + Livewire 3 (interactive, no separate JS build step)
- **Styling:** plain CSS, no Tailwind/build pipeline

Demo data: **5,200 books**, 2 staff accounts, 40 student accounts, and a mix of
active/overdue checkouts and holds so reports have something to show.

---

## Setup — Laravel Herd (macOS)

### 1. Get the project into place

Place the project in your Herd sites directory (typically `~/Herd`), then run:

```bash
cd smk-abc-library
composer install
```

### 2. Set up your `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Herd's bundled MySQL listens on `127.0.0.1:3306` with username `root` and an empty password by default.
The `.env.example` is already configured for this. Update `DB_USERNAME`/`DB_PASSWORD` if you've changed Herd's defaults.

### 3. Create the database

In Herd's "Database" tab or via the `mysql` CLI:

```sql
CREATE DATABASE smk_abc_library;
```

Make sure `DB_DATABASE` in `.env` matches.

### 4. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 5. Open the site

Herd auto-serves projects at `http://<folder-name>.test`, so this will be at
`http://smk-abc-library.test`. Update `APP_URL` in `.env` to match.

To run without Herd's auto-detection:

```bash
php artisan serve
```

Then visit `http://localhost:8000`.

---

## Setup — Laragon (Windows)

### 1. Get the project into place

Copy the project folder into Laragon's `www` directory (usually `C:\laragon\www\`):

```
C:\laragon\www\smk-abc-library\
```

Then open the Laragon terminal (or any terminal with PHP in PATH) and run:

```bash
cd C:\laragon\www\smk-abc-library
composer install
```

### 2. Set up your `.env`

```bash
copy .env.example .env
php artisan key:generate
```

Laragon's MySQL uses `root` with an empty password by default and listens on `127.0.0.1:3306`.
The `.env.example` is already set up for this. Update `DB_USERNAME`/`DB_PASSWORD` if yours differ.

### 3. Create the database

Open **Laragon → Database** (HeidiSQL) or use the Laragon menu **Database → Open HeidiSQL**, then run:

```sql
CREATE DATABASE smk_abc_library;
```

Or use the Laragon quick-create: right-click the Laragon tray icon → **MySQL → Create database**.

### 4. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

> **Note:** If `storage:link` fails on Windows due to permissions, run the terminal as Administrator and try again.

### 5. Open the site

Laragon auto-creates a virtual host for each folder in `www`. Restart Laragon after adding the project,
then visit `http://smk-abc-library.test`.

Update `APP_URL=http://smk-abc-library.test` in `.env` to match.

If the `.test` domain doesn't resolve, make sure Laragon's DNS is enabled:
**Laragon → Menu → Preferences → DNS → Enable DNS**.

---

## Demo logins

| Role    | Username    | Password     |
|---------|-------------|--------------|
| Admin   | `admin`     | `admin123`   |
| Admin   | `libstaff`  | `staff123`   |
| Student | `student1`  | `student123` |
| Student | `student2` … `student40` | `student123` |

---

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
- Add new books to the catalog (with optional cover image upload)
- Run reports: overdue list (with estimated fines), most-borrowed titles, inventory by genre

**Circulation rules baked in:**
- 14-day loan period
- 25¢/day late fee, calculated on return
- 5 active checkouts per student
- Returning a book automatically marks the next hold in line as "ready"
- Database-level row locking on checkout/return to avoid race conditions

---

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
      AuthController.php
      DashboardController.php
      AdminDashboardController.php
    Middleware/
      EnsureUserIsAuthenticated.php
      EnsureUserIsAdmin.php
  Livewire/
    Catalog.php
    BookDetail.php
    MyBooks.php
    MyHolds.php
    Admin/
      ActiveCheckouts.php
      HoldsQueue.php
      Reports.php
      AddBook.php
database/
  migrations/
  seeders/
resources/views/
  components/layouts/app.blade.php
  auth/login.blade.php
  admin/dashboard.blade.php
  livewire/
  vendor/pagination/custom.blade.php
public/css/style.css
config/library.php        # Circulation rule constants
```

## Customising circulation rules

All circulation constants are in `config/library.php` and can be overridden via `.env`:

```env
LIBRARY_LOAN_DAYS=14
LIBRARY_FINE_CENTS_PER_DAY=25
LIBRARY_MAX_CHECKOUTS_PER_STUDENT=5
```

## Before deploying to a real server

1. **Set `APP_ENV=production` and `APP_DEBUG=false`** in `.env`.
2. **Generate a real `APP_KEY`** via `php artisan key:generate` on the production server.
3. **Use HTTPS.** Put the app behind a reverse proxy with a TLS certificate.
4. **Real accounts.** Replace the demo seed accounts with real student/staff records.
5. **Backups.** Set up regular automated MySQL backups.
6. **Run migrations only — don't re-seed** on a production database that already has real data.
