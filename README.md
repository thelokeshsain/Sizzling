# Sizzling — Salon & Spa Booking System

A PHP and MySQL web application for customer salon service booking and administrative management of services and staff.

---

## Features

* **Online Booking:** Appointment reservation interface (`booking.html`, `book.php`).
* **Service Listings:** Public catalog of available treatments and services (`services.html`, `services.php`).
* **User Accounts:** User registration and login functionality.
* **Admin Dashboard:**
  * Add, edit, and delete salon services (`admin_services.php`, `add_service.php`, `delete_service.php`).
  * Add and remove salon staff members (`admin_staff.php`, `add_staff.php`, `remove_staff.php`).

---

## Tech Stack

* **Backend:** PHP
* **Database:** MySQL / MariaDB (`db_config.php`)
* **Frontend:** HTML5, CSS3, JavaScript

---

## Project Structure

```
Sizzling/
└── Sizzling-main/
    └── Pages/
        ├── index.html            # Landing page
        ├── about.html            # About page
        ├── services.html / php   # Services catalog
        ├── booking.html          # Appointment booking
        ├── book.php              # Booking handler
        ├── login.html / php      # User authentication
        ├── registration.html     # Account creation
        ├── admin_login.php       # Admin authentication
        ├── admin_dashboard.php   # Admin control panel
        ├── admin_services.php    # Service management
        ├── admin_staff.php       # Staff management
        └── db_config.php         # Database configuration
```

---

## Getting Started

### Prerequisites

* PHP (>= 7.4 or 8.x)
* MySQL / MariaDB (e.g., via XAMPP, WampServer, or LAMP)

### Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/thelokeshsain/Sizzling.git
   ```

2. **Copy to Web Root:**
   Move the folder to your web server document root (such as `htdocs` in XAMPP).

3. **Database Configuration:**
   Open `Sizzling-main/Pages/db_config.php` and configure database credentials (default database name is `sizzling`).

4. **Open in Browser:**
   Visit `http://localhost/Sizzling/Sizzling-main/Pages/index.html`.
