<?php

namespace App\Entities;

class BugTask extends Task {

    public function calculateComplexity(): int {
        return 5;
    }

    public function getRequiredSkills(): array {
        return ['Debugging', 'Testing'];
    }
    
}

?>

