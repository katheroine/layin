# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Documentation - short tutorial showing how to create a custom site using the chosen theme as a base.

## [0.1.1] - 2022-06-25
### Changed
- Fix console script wrongly includes autoloader [#25]

## [0.1.0] - 2022-06-25
### Added
- "Violet" theme with images, icons, CSS stylesheets, JS scripts and Twig templates (HTML + PHP code).
- Stickable dashboard (controls & navigation) panel.
- Accessibility features.
- Layin example site.
- Demo static pages (only HTML/CSS/JS with no PHP) based on Layin example site and published with GitHub Pages feature.
- Customizability & extendability for framework users (code organization, config files).
- Example of Apache web server configuration file for the virtual host.
- Console script for framework users, performing the basic jobs.

## [0.2.0] - 2022-10-07
### Added
- Possibility of configuration of the title & subtitle in the header.
- Possibility of configuration of the language code for the HTML document.
### Changed
- More descriptive keys of the configurable fields in the `config/site_config.yml` file to make them more the meaningful.

## [0.2.1] - 2022-10-17
### Fixed
- Fix navigation bug, when the document body was too small.
- Fix overflowing header banner bug, when its content were too long.

## [0.3.0] - 2023-01-01
### Added
- Possibility of configuration the concrete page renderer by the concrete preconfigured page renderers.
### Changed
- All paths of the config files must be configured separately in the preconfiguration.

## [0.4.0] - 2023-03-21
### Added
- README file with prerequisites, installation and basic set-up documentation.
- "Swamp Violet" theme with icons and CSS styles for content styling.
- Content layout samples page in the demo.
- VSC and Pexels links in the Favourites submenu of the demo.
### Changed
- Exceptions messages in loaders completed with the names of not found or improper files.
- PHP version added to requirements in `composer.json`.
- Logo made clickable.
- Layout pages in the demo moved from `layouts/board/` to `layouts/` path & content pages moved from `layouts/content/` to `content/` path.
### Removed
- File `composer.lock`.
