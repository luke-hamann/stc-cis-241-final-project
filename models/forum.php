<?php
class Forum {
    public $id;
    public $name;
    public $posts;

    public function __construct(int $id, string $name, array $posts) {
        $this->id = $id;
        $this->name = $name;
        $this->posts = $posts;
    }
}
?>
