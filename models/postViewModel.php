<?php
class PostViewModel {
    public $post;
    public $currentUser;

    public function __construct($post, $currentUser) {
        $this->post = $post;
        $this->currentUser = $currentUser;
    }
}
?>
