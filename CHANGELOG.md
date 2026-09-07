# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com), and this project adheres to [Semantic Versioning](https://semver.org).

## Unreleased

### Changed
- Upgrade to Laravel 13, Livewire 3, Jetstream 5, Sanctum 4, and Fortify 1.39
- Migrate to the slimmer Laravel application skeleton (`bootstrap/app.php`, `bootstrap/providers.php`)
- Upgrade to TailwindCSS 4, replacing PostCSS with the `@tailwindcss/vite` plugin
- Bump the minimum PHP version to 8.4

### Fixed
- Fix translucent table headers using a non-existent `bray` colour and the removed `bg-opacity-*` utility

## v2.0.1 (2023-06-07)

### Fixed
- Fix issue with missing navigation on mobile
- Fix issue with duplicated `attach` records

## v2.0.0 (2023-06-06)

### Added
- Rewrite application with TailwindCSS, Livewire, and Laravel 10

## v1.x (~2017)

If you are wanting v1.x of Cachent, please see the [`pxgamer/cachent`](https://github.com/pxgamer/cachent) repository.
