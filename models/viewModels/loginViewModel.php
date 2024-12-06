<?php
/**
 * Title: Login View Model
 * Purpose: To provide a view model for the login form
 */

require_once('./models/viewModels/_formViewModel.php');

class LoginViewModel extends FormViewModel {
    public $name;
    public $password;

    // Construct the view model
    public function __construct(string $name, string $password) {
        $this->name = $name;
        $this->password = $password;
    }

    // Construct the view model based on an associative array
    public static function fromArray(array $array) {
        $model = new LoginViewModel('', '');

        if (array_key_exists('name', $array)) {
            $model->name = $array['name'];
        }

        if (array_key_exists('password', $array)) {
            $model->password = $array['password'];
        }

        return $model;
    }

    // Validate the view model based upon the entered fields
    public function validate() {
        $this->_errors = [];

        if ($this->name == '') {
            $this->_errors[] = 'Please enter your name.';
        }

        if ($this->password == '') {
            $this->_errors[] = 'Please enter your password.';
        }
    }
}
?>
