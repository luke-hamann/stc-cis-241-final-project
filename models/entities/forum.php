<?php
/**
 * Title: Forum Model
 * Purpose: To represent a forum on the site
 */
class Forum {
    public $id;
    public $name;
    public $posts;

    // Construct a forum object
    public function __construct($id, $name, $posts) {
        $this->id = $id;
        $this->name = $name;
        $this->posts = $posts;
    }

    // Construct a forum object based on an associative array
    public static function fromArray(array $array) {
        $forum = new Forum(0, '', []);

        if (array_key_exists('id', $array) &&
            filter_var($array['id'], FILTER_VALIDATE_INT) !== false) {
            $forum->id = (int)$array['id'];
        }

        if (array_key_exists('name', $array)) {
            $forum->name = $array['name'];
        }

        return $forum;
    }

    // Validate the forum object and generate error messages if applicable
    public function getErrors() {
        $errors = [];

        if (preg_match('/^[a-z\d_-]{1,32}$/', $this->name) !== 1) {
            $errors[] = 'Forum name must be 1 to 32 characters long and ' .
            'contain only lowercase letters, numbers, hyphens, and underscores.';
        }

        return $errors;
    }
}
?>
