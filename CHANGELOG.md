# Release Notes

## v1.1.0 (2017-10-31)

### Added

- Added the ability to purge files using the `cachent:clear` command ([#17](https://github.com/pxgamer/cachent/issues/17))
- Added management of the admin account using the `cachent:admin` command ([#15](https://github.com/pxgamer/cachent/issues/15)/[#18](https://github.com/pxgamer/cachent/pull/18))

## v1.0.7 (2017-10-30)

### Added

- Added a purge function for administrators to purge the database ([#5](https://github.com/pxgamer/cachent/issues/5))
- Added listing of torrent's internal name ([#7](https://github.com/pxgamer/cachent/issues/7))

### Fixed

- Removed border top on first row of tables ([eca95f9](https://github.com/pxgamer/cachent/commit/eca95f9bb70cace718750a9e2b78bd92df627206))

## v1.0.6 (2017-09-12)

### Added
- Added downloads count for `torrents._info` view
- Added new `statistics.show` route for viewing stats for a specific torrent
- Added various navigation links to views for easier admin management

### Fixed
- Fixed minor issues on `torrents._info` view

## v1.0.5 (2017-09-12)

### Fixed
- Adjusted layout for hotfix

## v1.0.4 (2017-09-12)

### Added
- Added new `statistics.index` route for getting Cachent stats
- Added new method `Torrent::getTotalDownloads()` for getting the total downloads across all active torrents
- Added new column to the torrents table (`torrents.downloads`)
- Added download tracking for torrent files (only works when the file actually exists)

## v1.0.3 (2017-09-06)

### Added
- Added new classes for handling fixed tables and ellipsis text-overflow
- Admin panel at `/torrents` for viewing a paginated list of torrents
- Added support for admins soft deleting cached torrents

### Changed
- Split the `TorrentsController` resource routes into separate routes as it was redundant
- Updated the required PHP version to 7.1 to prevent issues when using Composer
- Merge ([#2](https://github.com/pxgamer/cachent/pull/2)) to change required PHP version in README

### Fixed
- Fixed `Torrent::addFileToDatabase()` function to correct issue where the `.torrent` exists but there is no record in the database

## v1.0.2 (2017-09-06)

### Added
- Added new classes for handling fixed tables and ellipsis text-overflow

### Changed
- Corrected styling for various elements which were incorrect on mobile devices

### Removed
- Removed the default `Example.vue` as it isn't being used

## v1.0.1 (2017-09-05)

### Changed
- Added badges and Composer installation option to [`README`](README.md)

## v1.0.0 (2017-09-05)

### Added
- Added Torrents routes for managing torrents
- Added Main route for index
- Added API module routes for JSON calls