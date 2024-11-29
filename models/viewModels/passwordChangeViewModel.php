<?php
/**
 * Title: Change Password View Model
 * Purpose: To provide a model for the password change form
 */

require_once('./models/viewModels/_formViewModel.php');

class PasswordChangeViewModel extends FormViewModel {
    public $passwordOld;
    public $passwordNew;
    public $passwordNewConfirm;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct($passwordOld, $passwordNew, $passwordNewConfirm, $currentUser) {
        $this->passwordOld = $passwordOld;
        $this->passwordNew = $passwordNew;
        $this->passwordNewConfirm = $passwordNewConfirm;
        $this->currentUser = $currentUser;
    }

    /**
     * Construct the view model based on an associative array
     */
    public static function fromArray(array $array) {
        $passwordOld = '';
        $passwordNew = '';
        $passwordNewConfirm = '';

        if (array_key_exists('passwordOld', $array)) {
            $passwordOld = $array['passwordOld'];
        }

        if (array_key_exists('passwordNew', $array)) {
            $passwordNew = $array['passwordNew'];
        }

        if (array_key_exists('passwordNewConfirm', $array)) {
            $passwordNewConfirm = $array['passwordNewConfirm'];
        }

        return new PasswordChangeViewModel(
            $passwordOld,
            $passwordNew,
            $passwordNewConfirm,
            null
        );
    }

    /**
     * Validate the view model based on the entered fields
     */
    public function validate() {
        $this->_errors = [];

        $badPasswords = false;

        if ($this->passwordOld == '') {
            $badPasswords = true;
            $this->_errors[] = 'Please enter your old password.';
        }

        if ($this->passwordNew == '') {
            $badPasswords = true;
            $this->_errors[] = 'Please enter your new password.';
        }

        if ($this->passwordNewConfirm == '') {
            $badPasswords = true;
            $this->_errors[] = 'Please confirm your new password.';
        }

        if (!$badPasswords) {
            if ($this->passwordNew != $this->passwordNewConfirm) {
                $this->_errors[] = 'Passwords do not match.';
            } else {
                $passwordError = User::isStrongPassword($this->passwordNew);
                if ($passwordError != '') {
                    $this->_errors[] = $passwordError;
                }
            }
        }
    }

    /**
     * Create a user object based on the change password form
     */
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
