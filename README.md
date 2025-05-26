# GitHub Task Importer for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/geobehr/stolic-tasks-githubproject.svg?style=flat-square)](https://packagist.org/packages/geobehr/stolic-tasks-githubproject)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/geobehr/stolic-tasks-githubproject/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/geobehr/stolic-tasks-githubproject/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/geobehr/stolic-tasks-githubproject.svg?style=flat-square)](https://packagist.org/packages/geobehr/stolic-tasks-githubproject)

A Laravel package that allows you to import task lists from Markdown files into GitHub Projects as issues and organize them in project columns.

## Features

- Parse Markdown task lists (`- [ ] Task 1`, `- [x] Completed Task`)
- Create GitHub issues from parsed tasks
- Add issues to specified GitHub Project columns
- Support for marking tasks as complete/incomplete
- Simple and intuitive API

## Use Case

This package is particularly useful when you want to quickly convert a Markdown task list (like a meeting minutes or project planning document) into actionable GitHub issues organized in a project board.

## Installation

You can install the package via Composer:

```bash
composer require geobehr/stolic-tasks-githubproject
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Geobehr\StolicTasksGithubproject\GitHubTaskImporterServiceProvider" --tag="config"
```

Then, add your GitHub token and default project ID to your `.env` file:

```env
GITHUB_TOKEN=your_github_token
GITHUB_PROJECT_ID=your_project_id
```

## Usage

```php
use Geobehr\StolicTasksGithubproject\GitHubTaskImporter;

$importer = new GitHubTaskImporter(env('GITHUB_TOKEN'), env('GITHUB_PROJECT_ID'));

$markdown = "- [ ] Task 1\n- [x] Completed Task";
$repository = 'your-username/your-repo';
$columnName = 'To Do';

$results = $importer->importTasks($markdown, $repository, $columnName);
```

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email geo@behrs.org instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [George Behr](https://github.com/geobehr)
- [All Contributors](../../contributors)
