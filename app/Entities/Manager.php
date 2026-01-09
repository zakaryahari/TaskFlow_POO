<?php

namespace App\Entities;

class Manager extends TeamMember {

    public function canCreateProject(): bool{
        return true;
    }

    public function canAssignTasks(): bool{
        return true;
    }

    public function getRolePermissions(): array{
        return ['CREATE_PROJECTS', 'ASSIGN_TASKS', 'VIEW_TEAM_REPORTS'];
    }

}

?>