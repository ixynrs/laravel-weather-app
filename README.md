<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Weather Application

This Laravel-based weather application allows users to fetch current weather data and a 5-day forecast for any city worldwide using the Weatherbit API.

## Features

- Current weather display
- 5-day weather forecast
- Search history tracking
- Caching to reduce API calls
- Responsive design using Tailwind CSS




## Screenshots

Here are some screenshots of the application:

![Home Page](public/images/1.png)
![Weather Data](public/images/2.png)
![Forecast Data](public/images/3.png)




## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Requirements

- PHP 7.4+
- Composer
- Laravel 8.x
- Weatherbit API key

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/ixynrs/laravel-weather-app.git
   cd laravel-weather-app
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:
   ```
   cp .env.example .env
   ```

4. Generate an application key:
   ```
   php artisan key:generate
   ```



5. Install SQLite

If you encounter an error indicating that the database cannot be found, follow these steps to install SQLite and set up your database:

- For Ubuntu or similar Linux distributions, install SQLite:
  ```bash
  sudo apt update
  sudo apt install sqlite3 libsqlite3-dev
  sudo apt install php-sqlite3
  ```

- Ensure that the `DB_CONNECTION` variable in your `.env` file is set to `sqlite`:
  ```ini
  DB_CONNECTION=sqlite
  ```

- Create a new SQLite database file in the `database` directory:
  ```bash
  touch database/database.sqlite
  ```

- Run the migrations again:
  ```bash
  php artisan migrate
  ```


6. Add your Weatherbit API key to the `.env` file:
   ```
   WEATHERBIT_API_KEY=your_api_key_here
   ```

## Usage

1. Start the Laravel development server:
   ```
   php artisan serve
   ```

2. Visit `http://localhost:8000` in your web browser.

3. Enter a city name and country code to fetch weather data.

## API Integration

This application uses the Weatherbit API. You'll need to sign up for a free account at [Weatherbit.io](https://www.weatherbit.io/) to get an API key.

## Caching

Weather data is cached for 30 minutes to reduce API calls. You can adjust the caching duration in the `WeatherController.php` file.

## Error Handling

The application includes basic error handling for API requests and invalid user inputs. Errors are logged and user-friendly messages are displayed.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# laravel-weather-app
