<?php
class Post {
    public $id;
    public $title;
    public $content;
    public $creationDate;
    public $userId;
    public $user;
    public $forumId;
    public $forum;

    public function __construct($id, $title, $content, $creationDate, $userId, $user, $forumId, $forum) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->userId = $userId;
        $this->user = $user;
        $this->forumId = $forumId;
        $this->forum = $forum;
    }
}
?>
