<?php
/**
 * Title: Password Change View Model
 * Purpose: To provide a model for the password change form
 */

require_once('./models/viewModels/_formViewModel.php');

class PasswordChangeViewModel extends FormViewModel {
    public $passwordOld;
    public $passwordNew;
    public $passwordNewConfirm;
    public $currentUser;

    // Construct the view model
    public function __construct($passwordOld, $passwordNew, $passwordNewConfirm, $currentUser) {
        $this->passwordOld = $passwordOld;
        $this->passwordNew = $passwordNew;
        $this->passwordNewConfirm = $passwordNewConfirm;
        $this->currentUser = $currentUser;
    }

    // Construct the view model based on an associative array
    public static function fromArray(array $array) {
        $model = new PasswordChangeViewModel('', '', '', null);

        if (array_key_exists('passwordOld', $array)) {
            $model->passwordOld = $array['passwordOld'];
        }

        if (array_key_exists('passwordNew', $array)) {
            $model->passwordNew = $array['passwordNew'];
        }

        if (array_key_exists('passwordNewConfirm', $array)) {
            $model->passwordNewConfirm = $array['passwordNewConfirm'];
        }

        return $model;
    }

    // Validate the view model based on the entered fields
    public function validate() {
        $this->_errors = [];

        $goodPasswords = true;

        if ($this->passwordOld == '') {
            $goodPasswords = false;
            $this->_errors[] = 'Please enter your old password.';
        }

        if ($this->passwordNew == '') {
            $goodPasswords = false;
            $this->_errors[] = 'Please enter your new password.';
        }

        if ($this->passwordNewConfirm == '') {
            $goodPasswords = false;
            $this->_errors[] = 'Please confirm your new password.';
        }

        if ($goodPasswords) {
            if ($this->passwordNew != $this->passwordNewConfirm) {
                $this->_errors[] = 'Passwords do not match.';
            } else {
                $passwordError = User::isValidPassword($this->passwordNew);
                if ($passwordError != '') {
                    $this->_errors[] = $passwordError;
                }
            }
        }
    }

    // Create a user object based on the password change form
    public function getUser() {
        return new User(
            $this->currentUser->id,
            $this->currentUser->name,
            $this->passwordNew,
            $this->currentUser->isAdmin,
            $this->currentUser->isGhost
        );
    }
}
?>
