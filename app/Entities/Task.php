<?php

namespace App\Entities;

abstract class Task {

    protected int $id;
    protected string $title;
    protected string $description;
    protected int $projectId;
    protected int $assigneeId;
    protected int $reporterId;
    protected string $priority;
    protected string $status;
    protected float $estimatedHours;
    protected float $actualHours;
    protected string $dueDate;
    protected string $createdAt;
    protected string $updatedAt;

    public function __construct(string $title, string $description, int $projectId, int $reporterId) {
        $this->title = $title;
        $this->description = $description;
        $this->projectId = $projectId;
        $this->reporterId = $reporterId;
        $this->status = 'TODO';
        $this->createdAt = date('Y-m-d H:i:s');
    }

    abstract public function calculateComplexity(): int;

    abstract public function getRequiredSkills(): array;
}

?>