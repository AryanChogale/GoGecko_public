# GoGecko — An Order Management System

A cloud-based order management platform developed as a venture of Star Hygiene Solution. Built with Laravel 11, Tailwind CSS, and Alpine.js.

🌐 **Live Site:** https://gogecko.onrender.com

---

## About

GoGecko simplifies the ordering process for businesses and customers across India. It allows customers to browse products, place orders, and track deliveries — with orders automatically routed to the nearest branch using real-time geolocation.

The platform operates on a three-role system:
- **Customer** — Browse products, manage cart, place orders, track delivery
- **Branch** — Manage assigned orders, submit price change requests
- **Admin** — Full control over products, branches, orders, blogs, and pricing

---

## Features

- Product catalogue with category and search filtering
- Guest cart + authenticated cart with merge on login
- Geolocation-based branch assignment using Nominatim (OpenStreetMap)
- WhatsApp & SMS order notifications via Twilio
- Secure online payments via Square
- Price change request system for branch staff
- Blog management
- Admin dashboard with live stats
- Fully mobile responsive

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11 (PHP 8.2) |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MySQL 8.0 |
| Payments | Square API |
| Notifications | Twilio (WhatsApp + SMS) |
| Geolocation | Nominatim (OpenStreetMap) |
| Build Tool | Vite |
| Deployment | Render + Clever Cloud |

---

## Local Setup

### Requirements
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Steps
```bash
# 1. Clone the repo
git clone https://github.com/AryanChogale/GoGecko_public.git
cd GoGecko_public

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies and build assets
npm install && npm run build

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure your .env
# Fill in DB_*, TWILIO_*, SQUARE_* values

# 6. Run migrations
php artisan migrate

# 7. Link storage
php artisan storage:link

# 8. Seed the database (optional)
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=BlogSeeder

# 9. Start the server
php artisan serve
```

Then visit `http://localhost:8000`

---

## Environment Variables

Copy `.env.example` to `.env` and fill in the following:

| Variable | Description |
|---|---|
| `APP_KEY` | Laravel app key (generated with `php artisan key:generate`) |
| `DB_*` | MySQL database credentials |
| `TWILIO_SID` | Twilio Account SID |
| `TWILIO_TOKEN` | Twilio Auth Token |
| `TWILIO_WHATSAPP_FROM` | Twilio WhatsApp sender number |
| `TWILIO_SMS_FROM` | Twilio SMS sender number |
| `TWILIO_TEMPLATE_SID` | Twilio WhatsApp template SID |
| `SQUARE_APP_ID` | Square application ID |
| `SQUARE_ACCESS_TOKEN` | Square access token |
| `SQUARE_LOCATION_ID` | Square location ID |
| `SQUARE_ENVIRONMENT` | `sandbox` or `production` |

---

## Deployment

The app is deployed using Docker on Render with a Clever Cloud MySQL database. See `Dockerfile` and `start.sh` for the deployment configuration.

---

## College Project

Developed as a BCA final year project at IBSAR, Tilak Maharashtra Vidyapeeth.

Built by Aryan Chogale and Sarvesh Patil.
