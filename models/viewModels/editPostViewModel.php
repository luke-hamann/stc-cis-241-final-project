<?php
/**
 * Title: Edit Post View Model
 * Purpose: To provide a model for adding and editing posts
 */

require_once('./models/viewModels/_formViewModel.php');

class EditPostViewModel extends FormViewModel {
    public $mode;
    public $post;
    public $forums;
    public $currentUser;

    /**
     * Construct th view model
     */
    public function __construct($mode, $post, $forums, $currentUser) {
        $this->mode = $mode;
        $this->post = $post;
        $this->forums = $forums;
        $this->currentUser = $currentUser;
    }

    /**
     * Validate the view model based on the contained post object
     */
    public function validate() {
        $this->_errors = $post->getErrors();
    }
}