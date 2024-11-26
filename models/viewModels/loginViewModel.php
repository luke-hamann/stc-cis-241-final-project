<?php
class LoginViewModel {
    public $name;
    public $password;
    public $currentUser;

    public function __construct(string $name, string $password, $currentUser) {
        $this->name = $name;
        $this->password = $password;
        $this->currentUser = $currentUser;
    }

    public static function fromArray(array $array) {
        $name = '';
        $password = '';

        if (array_key_exists('name', $array)) {
            $name = $array['name'];
        }

        if (array_key_exists('password', $array)) {
            $password = $array['password'];
        }

        return new LoginViewModel($name, $password, null);
    }

    public function getErrors() {
        $errors = array();

        if ($this->name == '') {
            $errors[] = 'Please enter a name.';
        }

        if ($this->password == '') {
            $errors[] = 'Please enter a password.';
        }

        return $errors;
    }

    public function isValid() {
        return (count($this->getErrors()) == 0);
    }
}
?>
