<?php
/**
 * Title: Forums View Model
 * Purpose: To provide a model for viewing a list of forums
 */
class ForumsViewModel {
    public $forums;
    public $currentUser;

    // Construct the view model
    function __construct($forums, $currentUser) {
        $this->forums = $forums;
        $this->currentUser = $currentUser;
    }
}
?>
