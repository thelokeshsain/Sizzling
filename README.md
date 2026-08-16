# 💇 Sizzling — Salon & Spa Booking Management System

A web-based appointment booking and salon administration portal developed in PHP and MySQL for managing customer reservations, treatment offerings, and staff schedules.

---

## ✨ Features

* **Customer Online Booking:** Interactive reservation interface (`booking.html` & `book.php`) for scheduling beauty and spa treatments.
* **Service Directory:** Dynamic catalog of grooming, hair, and spa packages with details and pricing.
* **User Authentication:** Customer registration and login sessions.
* **Admin Dashboard:** Central control panel for salon managers:
  * Add, update, and remove salon services (`admin_services.php`, `add_service.php`, `delete_service.php`).
  * Add and remove staff members (`admin_staff.php`, `add_staff.php`, `remove_staff.php`).
  * Review customer appointment bookings and contact inquiries.

---

## 🛠️ Tech Stack

* **Backend:** PHP
* **Database:** MySQL / MariaDB (`db_config.php`)
* **Frontend:** HTML5, CSS3, JavaScript

---

## 📁 Project Structure

```
Sizzling/
└── Sizzling-main/
    ├── Pages/
    │   ├── index.html            # Landing page
    │   ├── about.html            # Salon background & info
    │   ├── services.html         # Public treatment catalog
    │   ├── booking.html          # Appointment booking form
    │   ├── book.php              # Booking handler
    │   ├── login.html / php      # Customer login handlers
    │   ├── registration.html     # Customer registration form
    │   ├── admin_login.php       # Admin authentication
    │   ├── admin_dashboard.php   # Administrative overview
    │   ├── admin_services.php    # Service catalogue management
    │   ├── admin_staff.php       # Staff allocation & directory
    │   └── db_config.php         # MySQL database connection
    └── Assets / Styles           # CSS stylesheets and graphic assets
```

---

## 🚀 Getting Started

### Prerequisites

* **Local Web Server:** XAMPP, WampServer, LAMP, or PHP CLI (>= 7.4 / 8.x)
* **Database Server:** MySQL / MariaDB

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/thelokeshsain/Sizzling.git
   ```

2. **Deploy to Web Server:**
   * Move the project files to your server root (e.g., `htdocs/Sizzling` in XAMPP).

3. **Configure Database Connection:**
   * Open `Sizzling-main/Pages/db_config.php`.
   * Update the MySQL host, username, password, and database name to match your local setup.

4. **Access the application:**
   * Open `http://localhost/Sizzling/Sizzling-main/Pages/index.html` in your browser.

---

## 📄 License

Open for learning, portfolio demonstration, and academic web development purposes.
