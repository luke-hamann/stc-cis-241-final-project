<?php

require_once('./models/loginForm.php');
require_once('./models/registerForm.php');

if ($action == 'login' && $isGet) {
    include('./views/account/login.php');
    exit();
}

if ($action == 'login' && $isPost) {
    if (isset($currentUser)) {
        header('Location: .');
    }

    $loginForm = LoginForm::fromArray($_POST);

    if (!$loginForm->isValid()) {
        $errors = $loginForm->getErrors();
        include('./views/account/login.php');
        exit();
    }

    $user = UserDB::loginUser($loginForm->name, $loginForm->password);

    if (!isset($user)) {
        $errors = ['Invalid credentials.'];
        include('./views/account/login.php');
        exit();
    }

    $_SESSION['userId'] = $user->id;
    header('Location: .');
} 

if ($action == 'register' && $isGet) {
    if (isset($currentUser)) {
        header('Location: .');
    }

    include('./views/account/register.php');
    exit();
}

if ($action == 'register' && $isPost) {
    if (isset($currentUser)) {
        header('Location: .');
    }

    $registerForm = RegisterForm::fromArray($_POST);

    $errors = $registerForm->getErrors();
    if (UserDB::getUserByName($registerForm->name) !== null) {
        array_unshift($errors, 'Username is taken.');
    }

    if (count($errors) > 0) {
        include('./views/account/register.php');
        exit();
    }

    $userId = UserDB::addUser($registerForm->getUser());
    $_SESSION['userId'] = $userId;
    header('Location: .');
}

if ($action == 'logout' && $isPost) {
    $_SESSION = array();
    session_destroy();
    header('Location: .');
}

?>
