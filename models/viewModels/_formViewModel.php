<?php
/**
 * Title: Form View Model Abstract Class
 * Purpose: To provide a common interface for view models representing forms
 */
abstract class FormViewModel {
    protected $_errors = [];

    /**
     * Get the errors
     */
    public function getErrors() {
        return $this->_errors;
    }

    /**
     * Add an error to the error array
     */
    public function pushError(string $error) {
        $this->_errors[] = $error;
    }

    /**
     * Add an error to the start of the error array
     */
    public function unshiftError(string $error) {
        array_unshift($this->_errors, $error);
    }

    /**
     * Check whether the view model is valid
     */
    public function isValid() {
        return (count($this->_errors) == 0);
    }
}
