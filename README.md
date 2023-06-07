# Cachent

A secure, open source torrent cache.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-packagist]

## Install

Via Composer

```shell
composer create-project owenvoke/cachent
```

## Usage

### Requirements

- **PHP** >= 8.2
- **MySQL** >= 5.7, **MariaDB** >= 10.3, or [another supported database](https://laravel.com/docs/10.x/database#introduction)
- **Composer** >= 2.0
- **A PHP Compatible Webserver**

### Configuration

1. Run `composer install --no-dev` in the Cachent project directory.
2. Copy the `.env.example` file to `.env` and fill with your own database and mail details.
3. Ensure the `storage` and `bootstrap/cache` directories are writable by the server.
4. Run `php artisan key:generate` to generate a unique application key.
5. Set up your web server to point to the `public` directory.
6. Run `php artisan migrate` to update the database.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email security@voke.dev instead of using the issue tracker.

## Credits

- [Owen Voke][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/owenvoke/cachent.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/owenvoke/cachent.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/owenvoke/cachent
[link-author]: https://github.com/owenvoke
[link-contributors]: ../../contributors
