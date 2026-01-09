<?php

namespace App\Entities;

class Tester extends TeamMember {

    public function canCreateProject(): bool{
        return false;
    }

    public function canAssignTasks(): bool{
        return true;
    }

    public function getRolePermissions(): array{
        return ['TEST_TASKS', 'REVIEW_TASKS', 'REJECT_TASKS'];
    }

}

?>