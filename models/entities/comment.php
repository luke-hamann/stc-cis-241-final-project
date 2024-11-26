<?php
class Comment {
    public int $id;
    public string $content;
    public DateTime $creationDate;
    public int $postId;
    public int $userId;
    public User $user;

    public function __construct($id, $content, $creationDate, $postId, $userId, $user) {
        $this->id = $id;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->postId = $postId;
        $this->userId = $userId;
        $this->user = $user;
    }

    public static function fromArray(array $array) {
        if (array_key_exists('postId', $array)) {
            $postId = (int)$array['postId'];
        } else {
            $postId = 0;
        }

        if (array_key_exists('content', $array)) {
            $content = $array['content'];
        } else {
            $content = '';
        }

        return new Comment(
            0,
            $content,
            new DateTime(),
            $postId,
            0,
            new User(0, '', '', false)
        );
    }

    public function getErrors() {
        $errors = [];

        if (preg_match('/^.{1,1024}$/', $this->content) !== 1) {
            $errors[] = 'Content must be between 1 and 1,024 characters.';
        }

        return $errors;
    }
    
    public function isValid() {
        return (count($this->getErrors()) == 0);
    }
}
?>
