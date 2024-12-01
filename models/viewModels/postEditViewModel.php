<?php
/**
 * Title: Post Edit View Model
 * Purpose: To provide a model for the add post and edit post forms
 */

require_once('./models/viewModels/_formViewModel.php');

class PostEditViewModel extends FormViewModel {
    public $mode;
    public $post;
    public $forums;
    public $currentUser;

    /**
     * Construct the view model
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
        $this->_errors = $this->post->getErrors();
    }
}
