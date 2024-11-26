<?php
/**
 * Title: Post View Model
 * Purpose: To provide a model for viewing an individual post
 */

require_once('./models/viewModels/_formViewModel.php');

class PostViewModel extends FormViewModel {
    public $post;
    public $currentUser;
    public $comment;

    /**
     * Construct the view model
     */
    public function __construct($post, $currentUser, $comment) {
        $this->post = $post;
        $this->currentUser = $currentUser;
        $this->comment = $comment;
    }

    /**
     * Validate the view model based on the contained comment
     */
    public function validate() {
        $this->_errors = $this->comment->getErrors();
    }
}
?>
