<?php

namespace App\Entities;

class Developer extends TeamMember {

    public function canCreateProject(): bool{
        return false;
    }

    public function canAssignTasks(): bool{
        return true;
    }

    public function getRolePermissions(): array{
        return ['WORK_ON_TASKS', 'VIEW_ASSIGNED_TASKS'];
    }

}

?>