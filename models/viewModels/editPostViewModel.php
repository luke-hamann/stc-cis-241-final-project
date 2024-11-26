<?php
class EditPostViewModel {
    public $mode;
    public $post;
    public $forums;
    public $currentUser;

    public function __construct($mode, $post, $forums, $currentUser) {
        $this->mode = $mode;
        $this->post = $post;
        $this->forums = $forums;
        $this->currentUser = $currentUser;
    }

    public function isValid() {
        return $this->post->isValid();
    }

    public function getErrors() {
        return $this->post->getErrors();
    }
}