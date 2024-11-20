<?php
class Post {
    public $id;
    public $title;
    public $content;
    public $creationDate;
    public $userId;
    public $forumId;

    public function __construct($id, $title, $content, $creationDate, $userId, $forumId) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->userId = $userId;
        $this->forumId = $forumId;
    }
}
?>
