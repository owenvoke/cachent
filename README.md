# cachent

A secure, open source torrent cache.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-packagist]

## Install

1. Clone the repository using: `git clone https://github.com/pxgamer/cachent.git`  
    or using Composer: `composer create-project pxgamer/cachent`
1. From the `cachent` directory, install the Composer dependencies using `composer install`
1. Copy the `.env.example` to `.env`
1. Configure your `.env` file with your app and database details
1. Generate an application key using `php artisan key:generate`

**Production:**

1. Run the database migrations with `php artisan migrate`
1. Use the `php artisan cachent:admin` command to generate your admin account details

**Development:**

1. Run the database migrations with `php artisan migrate --seed` which will provide you with your admin details

## Usage

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
$ composer test
```

## Security

If you discover any security related issues, please email security@pxgamer.xyz instead of using the issue tracker.

## Credits

- [pxgamer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pxgamer/cachent.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/pxgamer/cachent.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pxgamer/cachent
[link-author]: https://github.com/pxgamer
[link-contributors]: ../../contributors
