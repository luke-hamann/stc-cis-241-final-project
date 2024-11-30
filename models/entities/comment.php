<?php
/**
 * Title: Comment Model
 * Purpose: To represent a comment on a post
 */
class Comment {
    public $id;
    public $content;
    public $creationDate;
    public $postId;
    public $post;
    public $userId;
    public $user;

    /**
     * Construct a comment object
     */
    public function __construct($id, $content, $creationDate, $postId, $post, $userId, $user) {
        $this->id = $id;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->postId = $postId;
        $this->post = $post;
        $this->userId = $userId;
        $this->user = $user;
    }

    /**
     * Construct a comment object based on an associative array
     */
    public static function fromArray(array $array) {
        $comment = new Comment(0, '', new DateTime(), 0, null, 0, null);
        
        if (array_key_exists('postId', $array) &&
            filter_var($array['postId'], FILTER_VALIDATE_INT) !== false) {
            $comment->postId = (int)$array['postId'];
        }

        if (array_key_exists('content', $array)) {
            $comment->content = $array['content'];
        }

        return $comment;
    }

    /**
     * Validate the comment and generate error messages if applicable
     */
    public function getErrors() {
        $errors = [];

        if (preg_match('/^.{1,1024}$/', $this->content) !== 1) {
            $errors[] = 'Content must be between 1 and 1,024 characters long.';
        }

        return $errors;
    }
}
?>
