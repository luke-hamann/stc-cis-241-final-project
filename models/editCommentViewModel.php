<?php
class EditCommentViewModel {
    public $comment;
    public $currentUser;

    public function __construct($comment, $currentUser) {
        $this->comment = $comment;
        $this->currentUser = $currentUser;
    }
}
?>
