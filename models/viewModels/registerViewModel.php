<?php
/**
 * Title: Register View Model
 * Purpose: To provide a view model for the registration form
 */

require_once('./models/viewModels/_formViewModel.php');

class RegisterViewModel extends FormViewModel {
    public $name;
    public $password;
    public $passwordConfirm;

    private static $namePattern =
        '/^[\d[:lower:]\-_]+$/';
    private static $passwordPattern =
        '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)()[^\n]{8,}$/';

    /**
     * Construct the view model
     */
    private function __construct(string $name, string $password, string $passwordConfirm) {
        $this->name = $name;
        $this->password = $password;
        $this->passwordConfirm = $passwordConfirm;
    }

    /**
     * Construct the view model based on an associative array
     */
    public static function fromArray(array $array) {
        $name = '';
        $password = '';
        $passwordConfirm = '';

        if (array_key_exists('name', $array)) {
            $name = $array['name'];
        }

        if (array_key_exists('password', $array)) {
            $password = $array['password'];
        }

        if (array_key_exists('passwordConfirm', $array)) {
            $passwordConfirm = $array['passwordConfirm'];
        }

        return new RegisterViewModel($name, $password, $passwordConfirm);
    }

    /**
     * Validate the view model based upon the entered fields
     */
    public function validate() {
        $this->_errors = [];

        if ($this->name == '') {
            $this->errors[] = 'Please enter a name.';
        } else if (preg_match(self::$namePattern, $this->name) !== 1) {
            $this->errors[] = 'Names must contain only numbers, lowercase letters, ' .
                'hyphens, and underscores.';
        }

        $badPassword = false;
        if (preg_match(self::$passwordPattern, $this->password) !== 1) {
            $this->errors[] = 'Password be at least 8 character long and ' .
                'contain at least one number, one lowercase letter, ' .
                'one uppercase letter, and one special character.';
            $badPassword = true;
        }

        if ($this->passwordConfirm == '') {
            $this->errors[] = 'Please confirm your password.';
        } else if (!$badPassword && ($this->password != $this->passwordConfirm)) {
            $this->errors[] = 'Passwords do not match.';
        }
    }
    
    public function getUser() {
        return new User(0, $this->name, $this->password);
    }
}
?>
