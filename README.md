# Pemira

Laravel 12 + TanStack Start (React 19) + Tailwind v4. Pakai Bun + Vite, SQLite default.

## Prasyarat

- PHP `^8.2` + Composer
- [Bun](https://bun.sh)
- Git

### Install PHP & Composer

Pakai [php.new](https://php.new) (cara cepat, lintas OS):

**Linux / macOS / WSL**

```bash
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
```

**Windows (PowerShell, run as Admin)**

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

Restart terminal → cek:

```bash
php -v
composer -V
```

### Install Bun

```bash
curl -fsSL https://bun.sh/install | bash
```

## Setup

```bash
git clone <repo-url> pemira
cd pemira
composer setup
```

`composer setup` jalanin: `composer install` → copy `.env` → `key:generate` → `migrate` → `bun install` → `bun run build`.

Kalau mau manual:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
bun install
```

## Dev

Jalanin semua (server + queue + log + vite) sekaligus:

```bash
composer dev
```

Atau pisah:

```bash
php artisan serve     # :8000
bun run dev           # vite
```

## Build

```bash
bun run build
```

## Test

```bash
composer test         # phpunit
bun run vitest        # frontend (kalau ada)
```

## Stack

- Backend: Laravel 12, Sanctum, SQLite
- Frontend: React 19, TanStack Router/Query/Start, Tailwind v4, Radix UI
- Tooling: Vite 8, Biome, Bun
