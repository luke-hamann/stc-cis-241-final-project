<?php
class ForumsViewModel {
    public $forums;
    public $currentUser;

    function __construct($forums, $currentUser) {
        $this->forums = $forums;
        $this->currentUser = $currentUser;
    }
}
?>
