<?php

use function Pest\testDirectory;
use Geobehr\StolicTasksGithubproject\MarkdownTaskParser;

test('it extracts tasks from markdown', function () {
    $parser = new MarkdownTaskParser();
    $markdown = "- [ ] Task 1\n- [x] Task 2";
    $tasks = $parser->extractTasks($markdown);

    expect($tasks)->toBe([
        ['title' => 'Task 1', 'completed' => false],
        ['title' => 'Task 2', 'completed' => true],
    ]);
});