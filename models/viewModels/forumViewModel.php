<?php
/**
 * Title: Forum View Model
 * Purpose: To provide a model for viewing an individual forum and its posts
 */
class ForumViewModel {
    public $forum;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct($forum, $currentUser) {
        $this->forum = $forum;
        $this->currentUser = $currentUser;
    }
}
?>
