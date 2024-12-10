<?php
/**
 * Title: User Model
 * Purpose: To represent a user on the site
 */
class User {
    public $id;
    public $name;
    public $password;
    public $isAdmin;
    public $isGhost;

    // Construct a user object
    public function __construct($id, $name, $password, $isAdmin, $isGhost) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->isGhost = $isGhost;
    }

    // Validate a potential username
    public static function isValidName(string $name) {
        $namePattern = '/^[a-z0-9_-]{1,32}$/';
        $error = '';
        if (preg_match($namePattern, $name) !== 1) {
            $error = 'Names must be 32 characters or less and ' .
                'contain only lowercase letters, numbers, hyphens, and underscores.';
        }
        return $error;
    }

    // Validate a potential password
    public static function isValidPassword(string $password) {
        $passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255}$/';
        $error = '';
        if (preg_match($passwordPattern, $password) !== 1) {
            $error = 'Password must be at least 8 characters long and ' .
                'contain at least one number, one lowercase letter, ' .
                'one uppercase letter, and one special character.';
        }
        return $error;
    }
}
