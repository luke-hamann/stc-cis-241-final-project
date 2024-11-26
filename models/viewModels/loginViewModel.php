<?php
/**
 * Title: Login View Model
 * Purpose: To provide a view model for the login form
 */

require_once('./models/viewModels/_formViewModel.php');

class LoginViewModel extends FormViewModel {
    public $name;
    public $password;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct(string $name, string $password, $currentUser) {
        $this->name = $name;
        $this->password = $password;
        $this->currentUser = $currentUser;
    }

    /**
     * Construct the view model based on an associative array
     */
    public static function fromArray(array $array) {
        $name = '';
        $password = '';

        if (array_key_exists('name', $array)) {
            $name = $array['name'];
        }

        if (array_key_exists('password', $array)) {
            $password = $array['password'];
        }

        return new LoginViewModel($name, $password, null);
    }

    /**
     * Validate the view model based upon the entered fields
     */
    public function validate() {
        $this->_errors = [];

        if ($this->name == '') {
            $this->_errors[] = 'Please enter a name.';
        }

        if ($this->password == '') {
            $this->_errors[] = 'Please enter a password.';
        }
    }
}
?>
