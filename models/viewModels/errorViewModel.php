<?php
/**
 * Title: Error View Model
 * Purpose: To provide a model for generic error pages
 */
class ErrorViewModel {
    public $title;
    public $body;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct($title, $body, $currentUser) {
        $this->title = $title;
        $this->body = $body;
        $this->currentUser = $currentUser;
    }
}
?>
