<?php
declare(strict_types=1);

namespace App\Core;

class Validator
{

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    public static function validateTaskPriority(string $priority): bool
    {
        return in_array($priority, ['low', 'medium', 'high', 'critical']);
    }
    public static function validatePasswordStrength(string $password): bool 
    {
      return strlen($password) > 8;
    }

    public static function validateFutureDate(string $date): bool 
    {
      if (strtotime($date) == time()) {
        return true;
      }
      return false;
    }

    public static function validateTitle(string $title): bool 
    {
        $length = strlen(trim($title));
        if ($length >= 3 && $length <= 150) {
            return true;
        }
        return false;
    }

    public static function validateHours(float $hours): bool 
    {
       return $hours > 0;
    }
}