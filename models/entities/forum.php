<?php
class Forum {
    public $id;
    public $name;
    public $posts;

    private static $namePattern = '/^[a-z\d_-]{1,32}$/';

    public function __construct(int $id, string $name, array $posts) {
        $this->id = $id;
        $this->name = $name;
        $this->posts = $posts;
    }

    public static function fromArray(array $array) {
        if (array_key_exists('id', $array)) {
            $id = (int)$array['id'];
        } else {
            $id = 0;
        }

        if (array_key_exists('name', $array)) {
            $name = $array['name'];
        } else {
            $name = '';
        }

        return new Forum($id, $name, []);
    }

    public function getErrors() {
        $errors = [];

        if (preg_match(self::$namePattern, $this->name) !== 1) {
            $errors[] = 'Forum name must be 1 to 32 characters and contain only lowercase letters, numbers, hyphens, and underscores.';
        }

        return $errors;
    }
}
?>