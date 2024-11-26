<?php
/**
 * Title: Users View Model
 * Purpose: To provide a model for viewing a list of all users
 */
class UsersViewModel {
    public $users;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct($users, $currentUser) {
        $this->users = $users;
        $this->currentUser = $currentUser;
    }
}
