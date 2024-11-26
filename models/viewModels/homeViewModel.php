<?php
class HomeViewModel {
    public $posts;
    public $currentUser;

    function __construct($posts, $currentUser) {
        $this->posts = $posts;
        $this->currentUser = $currentUser;
    }
}
?>
