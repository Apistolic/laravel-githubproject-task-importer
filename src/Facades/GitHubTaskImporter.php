<?php

namespace Geobehr\StolicTasksGithubproject\Facades;

use Illuminate\Support\Facades\Facade;

class GitHubTaskImporter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'github-task-importer';
    }
}
