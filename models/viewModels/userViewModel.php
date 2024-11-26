<?php
/**
 * Title: User View Model
 * Purpose: To provide a model for viewing an individual user
 */
class UserViewModel {
    public $user;
    public $mode;
    public $posts;
    public $comments;
    public $currentUser;

    public function __construct($user, $mode, $posts, $comments, $currentUser) {
        $this->user = $user;
        $this->mode = $mode;
        $this->posts = $posts;
        $this->comments = $comments;
        $this->currentUser = $currentUser;
    }
}
?>
