<?php
/**
 * Title: Forum Edit View Model
 * Purpose: To provide a model for adding and editing forums
 */

require_once('./models/viewModels/_formViewModel.php');

class ForumEditViewModel extends FormViewModel {
    public $forum;
    public $mode;
    public $currentUser;

    // Construct the view model
    public function __construct($forum, $mode, $currentUser) {
        $this->forum = $forum;
        $this->mode = $mode;
        $this->currentUser = $currentUser;
    }

    // Validate the view model by validating the contained forum object
    public function validate() {
        $this->_errors = $this->forum->getErrors();
    }
}
?>
