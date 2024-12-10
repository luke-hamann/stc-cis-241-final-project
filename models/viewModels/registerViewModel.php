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

    // Construct the view model
    public function __construct(string $name, string $password, string $passwordConfirm) {
        $this->name = $name;
        $this->password = $password;
        $this->passwordConfirm = $passwordConfirm;
    }

    // Construct the view model based on an associative array
    public static function fromArray(array $array) {
        $model = new RegisterViewModel('', '', '');

        if (array_key_exists('name', $array)) {
            $model->name = $array['name'];
        }

        if (array_key_exists('password', $array)) {
            $model->password = $array['password'];
        }

        if (array_key_exists('passwordConfirm', $array)) {
            $model->passwordConfirm = $array['passwordConfirm'];
        }

        return $model;
    }

    // Validate the view model based upon the entered fields
    public function validate() {
        $this->_errors = [];

        if ($this->name == '') {
            $this->_errors[] = 'Please enter a username.';
        } else {
            $nameError = User::isValidName($this->name);
            if ($nameError != '') {
                $this->_errors[] = $nameError;
            }
        }

        $goodPasswords = true;
        
        if ($this->password == '') {
            $goodPasswords = false;
            $this->_errors[] = 'Please enter a password.';
        }

        if ($this->passwordConfirm == '') {
            $goodPasswords = false;
            $this->_errors[] = 'Please confirm your password.';
        }

        if ($goodPasswords) {
            if ($this->password != $this->passwordConfirm) {
                $this->_errors[] = 'Passwords do not match.';
            } else {
                $passwordError = User::isValidPassword($this->password);
                if ($passwordError != '') {
                    $this->_errors[] = $passwordError;
                }
            }
        }
    }
    
    // Create a user object based on the registration form
    public function getUser() {
        return new User(0, $this->name, $this->password, false, false);
    }
}
?>
