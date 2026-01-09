<?php

namespace App\Interfaces;

interface Assignable {
    
    public function assignTo(int $memberId): void;
    
    public function unassign(): void;
    
    public function getAssigneeId(): ?int;
    
    public function isAssigned(): bool;
}

?>