<?php
class DeletionViewModel {
    public $id;
    public $summary;
    public $formActionStub;
    public $cancelUrl;
    public $currentUser;

    public function __construct($id, $summary, $formActionStub, $cancelUrl, $currentUser) {
        $this->id = $id;
        $this->summary = $summary;
        $this->formActionStub = $formActionStub;
        $this->cancelUrl = $cancelUrl;
        $this->currentUser = $currentUser;
    }
}
?>
