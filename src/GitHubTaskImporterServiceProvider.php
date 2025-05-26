<?php

namespace Geobehr\StolicTasksGithubproject;

use Illuminate\Support\ServiceProvider;

class GitHubTaskImporterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../config/github-task-importer.php' => config_path('github-task-importer.php'),
        ], 'config');
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/github-task-importer.php', 'github-task-importer');

        // Register the main class
        $this->app->singleton('github-task-importer', function ($app) {
            return new GitHubTaskImporter(
                $app['config']['github-task-importer']['github_token'],
                $app['config']['github-task-importer']['project_id']
            );
        });
    }
}