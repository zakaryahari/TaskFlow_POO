<?php

namespace App\Entities;

class MaintenanceTask extends Task {
    
    public function calculateComplexity(): int {
        return 3;
    }

    public function getRequiredSkills(): array {
        return ['Server Management', 'Documentation'];
    }
}

?>