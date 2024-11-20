<?php
class LoginForm {
    public $name;
    public $password;

    private function __construct(string $name, string $password) {
        $this->name = $name;
        $this->password = $password;
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

        return new LoginForm($name, $password);
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
