<?php

namespace Geobehr\StolicTasksGithubproject;

use GrahamCampbell\GitHub\Facades\GitHub;
use Github\Exception\RuntimeException;
use Geobehr\StolicTasksGithubproject\MarkdownTaskParser;

class GitHubTaskImporter
{
    protected $githubToken;
    protected $projectId;
    protected $parser;

    public function __construct(string $githubToken, string $projectId)
    {
        $this->githubToken = $githubToken;
        $this->projectId = $projectId;
        $this->parser = new MarkdownTaskParser();
    }

    public function importTasks(string $markdown, string $repository, string $columnName): array
    {
        // Parse Markdown to extract tasks
        $tasks = $this->parser->extractTasks($markdown);

        // Get repository details
        [$owner, $repo] = explode('/', $repository);

        // Find the project column ID
        $columnId = $this->getColumnId($columnName);

        $results = [];
        foreach ($tasks as $task) {
            try {
                // Create an issue for the task
                $issue = GitHub::issues()->create($owner, $repo, [
                    'title' => $task['title'],
                    'body' => 'Imported from Markdown task list',
                    'labels' => [$task['completed'] ? 'completed' : 'todo'],
                ]);

                // Add the issue to the project column
                GitHub::projects()->createCard($columnId, [
                    'content_id' => $issue['id'],
                    'content_type' => 'Issue',
                ]);

                $results[] = [
                    'title' => $task['title'],
                    'status' => 'success',
                    'issue_number' => $issue['number'],
                ];
            } catch (RuntimeException $e) {
                $results[] = [
                    'title' => $task['title'],
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    protected function getColumnId(string $columnName): int
    {
        $columns = GitHub::projects()->columns($this->projectId);
        foreach ($columns as $column) {
            if (strtolower($column['name']) === strtolower($columnName)) {
                return $column['id'];
            }
        }
        throw new \Exception("Column '$columnName' not found in project.");
    }
}