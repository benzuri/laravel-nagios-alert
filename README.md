# Laravel Nagios Alert System

A Laravel application that monitors minimum orders per store and generates Nagios-compatible alerts when specific conditions are not met.

## Requirements

- PHP 8.2 or higher
- Laravel 12
- Composer
- MySQL/MariaDB

## Features

- Processes CSV data with minimum order information
- Compares store values against reference store
- Generates Nagios-compatible alerts
- Configurable alert thresholds
- Scheduled execution via Laravel's task scheduler

<p><img src="/result.jpg"></p>

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/benzuri/laravel-nagios-alert.git
   cd laravel-nagios-alert
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations and seed the database:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. Place the CSV file in the storage directory:
   ```bash
   mkdir -p storage/app/data
   # Copy your datos.csv file to storage/app/data/
   ```

## Usage

### Running the Command Directly

To run the store orders check command directly:

```bash
php artisan orders:check
```

This will process the CSV data, check for violations, and output a Nagios-compatible alert string.

### Running the Scheduled Task

To test the scheduled task locally:

```bash
php artisan schedule:work
```

This command will run in the foreground and execute any scheduled tasks according to their defined schedule. In our case, the `orders:check` command is scheduled to run every minute.

### Viewing the Output

The command output is saved to a log file for review:

```bash
cat storage/logs/nagios/YYYY-MM-DD-check-store-orders.log
```

Replace `YYYY-MM-DD` with the current date.

## External Libraries

This project uses the following external libraries:

- **Spatie Simple Excel** (^3.7) - A package for reading and writing simple Excel and CSV files with minimal memory usage.

## Project Structure

- `app/Console/Commands/CheckStoreOrders.php` - The main command
- `app/Services/Nagios/AlertService.php` - Service for formatting Nagios alerts
- `app/Services/StoreOrders/StoreOrderAnalysisService.php` - Service for processes the CSV data and generates alerts
- `app/Models/StoreWebsite.php` - Model representing the store website table
- `database/migrations` - Database migration files
- `database/seeders` - Database seeder files
- `storage/app/data/datos.csv` - CSV file containing order data

## Alert Format

The command generates alerts in the following format:

```
WARNING - Incidencia ventas horas | store pt, app=0, valor = 1879 | store pt, app=0, valor = 796.5 | store pt, app=0, valor = 327 | store pt, app=0, valor = 162 | store pt, app=0, valor = 116 | store pt, app=0, valor = 118 | store pt, app=0, valor = 282 | store pt, app=0, valor = 672.5 | store pt, app=0, valor = 1292.5 | store pt, app=0, valor = 1801 | store pt, app=0, valor = 2117 | store pt, app=0, valor = 2224 | store pt, app=0, valor = 2181 | store pt, app=0, valor = 1979 | store pt, app=0, valor = 1693 | store pt, app=0, valor = 1877.5 | store pt, app=0, valor = 2109.5 | store pt, app=0, valor = 2044.5 | store pt, app=0, valor = 2066.5 | store pt, app=0, valor = 2286.5 | store pt, app=0, valor = 2273.5 | store pt, app=0, valor = 2419.5 | store pt, app=0, valor = 2704 | store pt, app=0, valor = 3108 | store ea, app=0, valor = 217 | store ea, app=0, valor = 1392 | store ea, app=0, valor = 1801 | store ea, app=0, valor = 1665 | store ea, app=0, valor = 698 | store ea, app=0, valor = 1571 | store ea, app=0, valor = 622 | store ea, app=0, valor = 733 | store ea, app=0, valor = 1920 | store ea, app=0, valor = 709 | store ea, app=0, valor = 2246 | store pt, app=1, valor = 871 | store pt, app=1, valor = 313 | store pt, app=1, valor = 224 | store pt, app=1, valor = 555 | store ea, app=1, valor = 880 | store ea, app=1, valor = 525 | store ea, app=1, valor = 299 | store ea, app=1, valor = 537 | store ea, app=1, valor = 686 | store ea, app=1, valor = 133 | store ea, app=1, valor = 1401 | store ea, app=1, valor = 366 | store ea, app=1, valor = 142 | store ea, app=1, valor = 469
```

This format is compatible with Nagios monitoring system and will be properly interpreted as a warning status.
