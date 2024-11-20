<?php
class Post {
    public int $id;
    public string $title;
    public string $content;
    public DateTime $creationDate;
    public int $userId;
    public User $user;
    public int $forumId;
    public Forum $forum;
    public $comments;

    private static $titlePattern = '/^[^\n]{1,128}$/';
    private static $contentPattern = '/^.{1,1024}$/';

    public function __construct($id, $title, $content, $creationDate, $userId, $user, $forumId, $forum, $comments) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->creationDate = $creationDate;
        $this->userId = $userId;
        $this->user = $user;
        $this->forumId = $forumId;
        $this->forum = $forum;
        $this->comments = $comments;
    }

    public static function fromArray(array $array) {
        if (array_key_exists('id', $array)) {
            $id = (int)$array['id'];
        } else {
            $id = 0;
        }

        if (array_key_exists('title', $array) && gettype($array['title'] == 'string')) {
            $title = $array['title'];
        } else {
            $title = '';
        }

        if (array_key_exists('content', $array) && gettype($array['content'] == 'string')) {
            $content = $array['content'];
        } else {
            $content = '';
        }

        if (array_key_exists('forumId', $array)) {
            $forumId = (int)$array['forumId'];
        } else {
            $forumId = 0;
        }

        return new Post(
            $id,
            $title,
            $content,
            new DateTime(),
            0,
            new User(0, '', ''),
            $forumId,
            new Forum(0, '', []),
            []
        );
    }

    public function getErrors() {
        $errors = [];

        if ($this->forumId < 1) {
            $errors[] = 'Please select a forum.';
        }

        if (preg_match(self::$titlePattern, $this->title) !== 1) {
            $errors[] = 'Please enter a title of 1 to 128 characters.';
        }

        if (preg_match(self::$contentPattern, $this->content) !== 1) {
            $errors[] = 'Please enter content of 1 to 1024 characters.';
        }

        return $errors;
    }

    public function isValid() {
        return (count($this->getErrors()) == 0);
    }
}
?>
