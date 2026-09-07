# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com), and this project adheres to [Semantic Versioning](https://semver.org).

## Unreleased

### Added
- Add test coverage for the upload, details, and download flow

### Changed
- Upgrade to Laravel 13, Livewire 3, Jetstream 5, Sanctum 4, and Fortify 1.39
- Migrate to the slimmer Laravel application skeleton (`bootstrap/app.php`, `bootstrap/providers.php`)
- Upgrade to TailwindCSS 4, replacing PostCSS with the `@tailwindcss/vite` plugin
- Bump the minimum PHP version to 8.4
- Replace the unmaintained `coldwinds/torrent-rw` with `arokettu/torrent-file`, which also
  understands v2 torrents (info hashes are unchanged, so existing torrents keep working)
- Replace the unmaintained `rych/bytesize` with Laravel's `Number::fileSize()`, which reports
  sizes as `4.59 GB` rather than `4.59GiB`
- Use Fortify's default password hashing by adding the `hashed` cast to the user model
- Serve cached torrents through a dedicated `torrents` filesystem disk
- Drop the direct `guzzlehttp/guzzle` requirement; it is a dependency of the framework

### Fixed
- Fix torrent downloads 404ing after the upgrade, as Laravel 11 moved the `local` disk root
  from `storage/app` to `storage/app/private`
- Fix translucent table headers using a non-existent `bray` colour and the removed `bg-opacity-*` utility
- Replace Fortify's deprecated `Password` rule with `Illuminate\Validation\Rules\Password`

## v2.0.1 (2023-06-07)

### Fixed
- Fix issue with missing navigation on mobile
- Fix issue with duplicated `attach` records

## v2.0.0 (2023-06-06)

### Added
- Rewrite application with TailwindCSS, Livewire, and Laravel 10

## v1.x (~2017)

If you are wanting v1.x of Cachent, please see the [`pxgamer/cachent`](https://github.com/pxgamer/cachent) repository.
