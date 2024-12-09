<?php
/**
 * Title: User View Model
 * Purpose: To provide a model for viewing an individual user and their posts or comments
 */
class UserViewModel {
    public $user;
    public $mode;
    public $posts;
    public $comments;
    public $currentUser;

    // Construct the view model
    public function __construct($user, $mode, $posts, $comments, $currentUser) {
        $this->user = $user;
        $this->mode = $mode;
        $this->posts = $posts;
        $this->comments = $comments;
        $this->currentUser = $currentUser;
    }
}
?>
