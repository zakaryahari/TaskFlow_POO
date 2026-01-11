<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TeamMemberRepository;
use Exception;

class ProjectService {
    private ProjectRepository $projectRepo;
    private TaskRepository $taskRepo;
    private TeamMemberRepository $userRepo;

    public function __construct() {
        $this->projectRepo = new ProjectRepository();
        $this->taskRepo = new TaskRepository();
        $this->userRepo = new TeamMemberRepository();
    }

    public function createProject(array $data, int $requesterId): bool {
        try {
            $user = $this->userRepo->find($requesterId);

            if ($user['role'] === 'developer' || empty($data['team_id'])) {
                return false;
            }

            return $this->projectRepo->save($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getProjectStats(int $projectId): array {
        try {
            $tasks = $this->taskRepo->findByProject($projectId);
            $stats = ['total' => count($tasks), 'todo' => 0, 'in_progress' => 0, 'done' => 0];

            foreach ($tasks as $task) {
                $status = $task['status'];
                if (isset($stats[$status])) {
                    $stats[$status]++;
                }
            }

            return $stats;
        } catch (Exception $e) {
            return [];
        }
    }

    public function archiveProject(int $projectId): bool {
        try {
            $tasks = $this->taskRepo->findByProject($projectId);
            
            foreach ($tasks as $task) {
                if ($task['status'] !== 'done') {
                    return false;
                }
            }

            $project = $this->projectRepo->find($projectId);
            $project['status'] = 'archived';
            
            return $this->projectRepo->save($project);
        } catch (Exception $e) {
            return false;
        }
    }
}