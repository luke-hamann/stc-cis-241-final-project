<?php
/**
 * Title: Post View Model
 * Purpose: To provide a model for viewing an individual post
 */
class PostViewModel {
    public $post;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct($post, $currentUser) {
        $this->post = $post;
        $this->currentUser = $currentUser;
    }
}
?>
