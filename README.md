# cachent

A secure, open source torrent cache.

[![Version](https://img.shields.io/packagist/v/pxgamer/cachent.svg)](https://packagist.org/p/pxgamer/cachent)
[![License](https://img.shields.io/packagist/l/pxgamer/cachent.svg)](https://opensource.org/licenses/mit-license)

## Dependencies

- [Composer]
- PHP 7.1 or greater
- A web server

## Installation

1. Clone the repository using: `git clone git@github.com:PXgamer/cachent.git`
    or initialise using `composer create-project pxgamer/cachent`
2. From the `cachent` directory, install the [Composer] dependencies using `composer install`
3. Copy the `.env.example` to `.env`
4. Configure your `.env` file with your app and database details
5. Generate an application key using `php artisan key:generate`
6. Run the database migrations with `php artisan migrate --seed` which will provide you with your admin details

[Composer]: https://getcomposer.org
