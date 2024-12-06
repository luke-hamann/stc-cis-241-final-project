<?php
/**
 * Title: Reset Password Result View Model
 * Purpose: To provide a model for viewing the result of a password reset
 */
class PasswordResetViewModel {
    public $selectedUser;
    public $currentUser;

    // Construct the view model
    public function __construct($selectedUser, $currentUser) {
        $this->selectedUser = $selectedUser;
        $this->currentUser = $currentUser;
    }
}
?>
