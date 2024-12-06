<?php
/**
 * Title: Comment Edit View Model
 * Purpose: To provide a model for the comment edit form
 */

require_once('./models/viewModels/_formViewModel.php');

class CommentEditViewModel extends FormViewModel {
    public $comment;
    public $currentUser;

    // Construct the view model
    public function __construct($comment, $currentUser) {
        $this->comment = $comment;
        $this->currentUser = $currentUser;
    }

    // Validate the view model by validating the contained comment object
    public function validate() {
        $this->_errors = $this->comment->getErrors();
    }
}
?>
