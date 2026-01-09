<?php

namespace App\Entities;

class FeatureTask extends Task {
    public function calculateComplexity(): int {
        return 8; 
    }

    public function getRequiredSkills(): array {
        return ['Backend', 'API Design'];
    }
}

?>