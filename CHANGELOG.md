# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

## 1.1.0 - 2026-02-02

### Added

- Symfony 8.x support (requires PHP 8.4+ for Symfony 8; PHP 8.2+ still supported with Symfony 5-7)

## 1.0.0 - 2025-10-29

### Added

- Symfony 7.x support with comprehensive CI test matrix
- PHPUnit 10.x test suite with comprehensive coverage
- Runtime type validation for pipeline stages
- `composer test` command for running tests
- `composer test-coverage` command for generating coverage reports
- `composer quality` command for running all quality checks
- CI/CD integration for automated test execution
- Automated dependency updates via Renovate

### Changed

- Updated PHPStan to v2 with improved static analysis
- Updated Rector to v2.x for modern PHP refactoring
- Updated PHP_CodeSniffer to ~3.11.0
- Improved PHPUnit coverage configuration
- Updated GitHub Actions to v4 (checkout and cache)

### Fixed

- PHPUnit coverage warnings in CI matrix tests
- Rector configuration for version 2.x compatibility
- Use current bundle name in README

## 0.1.0 - 2023-06-16

### Added

- Initial release
- Add pipeline factory
