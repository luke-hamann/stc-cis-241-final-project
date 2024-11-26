<?php
class ForumViewModel {
    public $forum;
    public $currentUser;

    public function __construct($forum, $currentUser) {
        $this->forum = $forum;
        $this->currentUser = $currentUser;
    }
}
?>
