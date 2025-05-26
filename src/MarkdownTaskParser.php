<?php

namespace Geobehr\StolicTasksGithubproject;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Renderer\HtmlRenderer;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Extension\TaskList\TaskListItemMarker;

class MarkdownTaskParser
{
    protected $parser;
    protected $renderer;

    public function __construct()
    {
        $environment = new Environment();
        $environment->addExtension(new TaskListExtension());
        $this->parser = new MarkdownParser($environment);
        $this->renderer = new HtmlRenderer($environment);
    }

    public function extractTasks(string $markdown): array
    {
        $document = $this->parser->parse($markdown);
        $tasks = [];

        // Find all nodes in the document
        $walker = $document->walker();
        while (($event = $walker->next())) {
            $node = $event->getNode();
            
            // Only process when entering a node
            if (!$event->isEntering() || !$node instanceof TaskListItemMarker) {
                continue;
            }
            
            $taskText = '';
            $checked = $node->isChecked();
            $listItem = $node->parent();
            
            // Get the text content of the list item
            foreach ($listItem->children() as $child) {
                if ($child instanceof Text) {
                    $taskText .= $child->getLiteral();
                }
            }
            
            $tasks[] = [
                'title' => trim($taskText),
                'completed' => $checked,
            ];
        }

        return $tasks;
    }
}
