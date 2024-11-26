<?php
/**
 * Title: User Model
 * Purpose: To represent a user on the site
 */
class User {
    public $id;
    public $name;
    public $password;
    public $admin;

    /**
     * Construct a user object
     */
    public function __construct($id, $name, $password, $admin) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->admin = $admin;
    }
}
