<?php
/**
 * Title: Post Model
 * Purpose: To represent a post on the site
 */
class Post {
    public $id;
    public $title;
    public $content;
    public $creationDate;
    public $userId;
    public $user;
    public $forumId;
    public $forum;
    public $comments;
    public $isDeleted;

    /**
     * Construct a post object
     */
    public function __construct($id, $title, $content, $creationDate,
        $userId, $user, $forumId, $forum, $comments, $isDeleted) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->userId = $userId;
        $this->user = $user;
        $this->forumId = $forumId;
        $this->forum = $forum;
        $this->comments = $comments;
        $this->isDeleted = $isDeleted;
    }

    /**
     * Construct a post object based on an associative array
     */
    public static function fromArray(array $array) {
        $post = new Post(0, '', '', new DateTime(), 0, null, 0, null, [], false);

        if (array_key_exists('id', $array) &&
            filter_var($array['id'], FILTER_VALIDATE_INT) !== false) {
            $post->id = (int)$array['id'];
        }

        if (array_key_exists('title', $array)) {
            $post->title = $array['title'];
        }

        if (array_key_exists('content', $array)) {
            $post->content = $array['content'];
        }

        if (array_key_exists('forumId', $array) &&
            filter_var($array['forumId'], FILTER_VALIDATE_INT) !== false) {
            $post->forumId = (int)$array['forumId'];
        }

        return $post;
    }

    /**
     * Validate the post and generate error messages if applicable
     */
    public function getErrors() {
        $errors = [];

        if ($this->forumId < 1) {
            $errors[] = 'Please select a forum.';
        }

        if (preg_match('/^[^\n]{1,128}$/', $this->title) !== 1) {
            $errors[] = 'Please enter a title of 1 to 128 characters.';
        }

        if (preg_match('/^.{1,1024}$/', $this->content) !== 1) {
            $errors[] = 'Please enter content of 1 to 1024 characters.';
        }

        return $errors;
    }
}
?>
