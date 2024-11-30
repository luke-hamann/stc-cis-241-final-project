<?php
/**
 * Title: Home View Model
 * Purpose: To provide a model for viewing recent posts on the home page
 */
class HomeViewModel {
    public $posts;
    public $currentUser;

    /**
     * Construct the view model
     */
    function __construct($posts, $currentUser) {
        $this->posts = $posts;
        $this->currentUser = $currentUser;
    }
}
?>
