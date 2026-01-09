<?php

namespace App\Entities;

abstract class TeamMember {

    protected int $id;
    protected string $username;
    protected string $email;
    protected int $teamId;
    protected string $createdAt;
    protected string $password;

    public function __construct(string $username, string $email, string $password, int $teamId) {
        $this->username = $username;
        $this->email = $email;
        $this->setPassword($password);
        $this->teamId = $teamId;
        $this->createdAt = date('Y-m-d');
    }

    abstract public function canCreateProject(): bool;

    abstract public function canAssignTasks(): bool;

    abstract public function getRolePermissions(): array;

    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $password): bool {
        if (password_verify($password , $this->password)) {
            return true;
        }
        return false; 
    }

}