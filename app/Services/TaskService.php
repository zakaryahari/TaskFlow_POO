<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Repositories\TeamMemberRepository;
use Exception;

class TaskService {
    private TaskRepository $taskRepo;
    private TeamMemberRepository $userRepo;

    public function __construct() {
        $this->taskRepo = new TaskRepository();
        $this->userRepo = new TeamMemberRepository();
    }

    public function createTask(array $data): bool {
        try {
            if ($data['estimated_hours'] <= 0) {
                return false;
            }

            if ($data['priority'] === 'critical' && empty($data['due_date'])) {
                return false;
            }

            return $this->taskRepo->save($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function assignTask(int $taskId, int $assigneeId, int $requesterId): bool {
        try {
            $requester = $this->userRepo->find($requesterId);
            
            if (!$requester || $requester['role'] !== 'manager') {
                return false;
            }

            return $this->taskRepo->assignTask($taskId, $assigneeId);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateStatus(int $taskId, string $newStatus): bool {
        try {
            $task = $this->taskRepo->find($taskId);
            if (!$task) {
                return false;
            }

            $currentStatus = $task['status'];
            $allowed = false;

            if ($currentStatus === 'todo' && $newStatus === 'in_progress') $allowed = true;
            if ($currentStatus === 'in_progress' && ($newStatus === 'done' || $newStatus === 'todo')) $allowed = true;
            if ($currentStatus === 'done' && $newStatus === 'in_progress') $allowed = true;

            if (!$allowed) {
                return false;
            }

            $task['status'] = $newStatus;
            return $this->taskRepo->save($task);
        } catch (Exception $e) {
            return false;
        }
    }

    public function logHours(int $taskId, float $hours): bool {
        try {
            if ($hours <= 0) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>