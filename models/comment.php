<?php
class Comment {
    public $id;
    public $content;
    public $creationDate;
    public $postId;
    public $userId;

    public function __construct($id, $content, $creationDate, $postId, $userId) {
        $this->id = $id;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->postId = $postId;
        $this->userId = $userId;
    }
}
?>
