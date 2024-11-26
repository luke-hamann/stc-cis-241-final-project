<?php
class User {
    public $id;
    public $name;
    public $password;
    public $admin;

    public function __construct($id, $name, $password, $admin) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->admin = $admin;
    }
}
