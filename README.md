# Pharmacy Management System

A PHP MVC-based application for managing pharmacy inventory, sales, and reports.

## Features

- Dashboard with real-time statistics and charts
- Medicine inventory management
- Categories and suppliers management
- Sales tracking and management
- Low stock alerts
- Monthly sales reports
- User management with role-based access

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- mod_rewrite enabled

## Installation

1. Clone this repository to your web server's document root (e.g., `htdocs` for XAMPP)
2. Create a MySQL database named `pharmacy_db`
3. Import the `pharmacy_db.sql` file to set up the database schema and sample data
4. Update database credentials in `config/config.php` if needed
5. Configure your web server to use the `.htaccess` file for URL rewriting
6. Visit `http://localhost/mvc` in your browser to access the application

## Default Login

- Email: admin@pharmacy.com
- Password: admin123

## Directory Structure

```
mvc/
├── app/
│   ├── controllers/    # Controller classes
│   ├── models/         # Model classes
│   └── views/          # View files
├── config/             # Configuration files
├── core/               # Core framework files
├── public/             # Publicly accessible files
│   ├── css/            # CSS files
│   ├── js/             # JavaScript files
│   └── img/            # Image files
└── .htaccess           # URL rewriting rules
```

## Usage

- Dashboard: View key metrics, low stock medicines, and recent sales
- Medicines: Manage your medicine inventory, add, edit, or delete medicines
- Categories: Organize medicines into categories
- Suppliers: Manage medicine suppliers
- Sales: Record and track medicine sales
- Reports: Generate and view various pharmacy reports
- Users: Manage system users

## License

This project is open-source software licensed under the MIT License. 