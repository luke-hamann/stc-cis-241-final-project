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
     * Construct a comment object based on an associate array
     */
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
            null,
            0,
            new User(0, '', '', false, false)
        );
    }

    /**
     * Validate the comment and generate error messages if applicable
     */
    public function getErrors() {
        $errors = [];

        if (preg_match('/^.{1,1024}$/', $this->content) !== 1) {
            $errors[] = 'Content must be between 1 and 1,024 characters.';
        }

        return $errors;
    }
}
?>
