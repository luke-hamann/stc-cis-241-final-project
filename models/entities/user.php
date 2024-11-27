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

    /**
     * Construct a user object
     */
    public function __construct($id, $name, $password, $isAdmin, $isGhost) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->isGhost = $isGhost;
    }

    public static function isValidName(string $name) {
        $namePattern = '/^[\d[:lower:]\-_]+$/';
        $error = '';
        if (preg_match($namePattern, $name) !== 1) {
            $error = 'Names must contain only numbers,' .
            'lowercase letters, hyphens, and underscores.';
        }
        return $error;
    }

    public static function isStrongPassword(string $password) {
        $passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)()[^\n]{8,}$/';
        $error = '';
        if (preg_match($passwordPattern, $password) !== 1) {
            $error = 'Password be at least 8 character long and ' .
                'contain at least one number, one lowercase letter, ' .
                'one uppercase letter, and one special character.';
        }
        return $error;
    }
}
