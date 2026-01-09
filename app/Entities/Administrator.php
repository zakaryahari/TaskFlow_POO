<?php

namespace App\Entities;

class Administrator extends TeamMember {
    
    public function canCreateProject(): bool {
        return true;
    }

    public function canAssignTasks(): bool {
        return true;
    }

    public function getRolePermissions(): array {
        return ['MANAGE_TEAMS', 'MANAGE_MEMBERS', 'SYSTEM_SETTINGS'];
    }
}