<?php
/**
 * Title: Deletion View Model
 * Purpose: To provide a view model for arbitrary deletion confirmation forms
 */
class DeletionViewModel {
    public $id;
    public $summary;
    public $formActionStub;
    public $cancelUrl;
    public $currentUser;

    /**
     * Construct the view model
     */
    public function __construct($id, $summary, $formActionStub, $cancelUrl, $currentUser) {
        $this->id = $id;
        $this->summary = $summary;
        $this->formActionStub = $formActionStub;
        $this->cancelUrl = $cancelUrl;
        $this->currentUser = $currentUser;
    }
}
?>
