<?php
class EditForumViewModel {
    public $forum;
    public $mode;
    public $currentUser;

    public function __construct($forum, $mode, $currentUser) {
        $this->forum = $forum;
        $this->mode = $mode;
        $this->currentUser = $currentUser;
    }
}
?>
