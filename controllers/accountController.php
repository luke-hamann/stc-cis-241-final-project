<?php
/**
 * Title: Account Controller
 * Purpose: To manage user sessions, including logins, logouts, and registrations
 */

require_once('./models/loginForm.php');
require_once('./models/registerForm.php');

function sendHomeIfLoggedIn($currentUser) {
    if (isset($currentUser)) {
        header('Location: .');
    }
}

/**
 * Display the login form
 */
if ($action == 'login' && $isGet) {
    sendHomeIfLoggedIn($currentUser);
    include('./views/account/login.php');
    exit();
}

/**
 * Accept form data for logging in
 */
if ($action == 'login' && isPost) {
    sendHomeIfLoggedIn($currentUser);

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

/**
 * Display the registration form
 */
if ($action == 'register' && $isGet) {
    sendHomeIfLoggedIn($currentUser);
    include('./views/account/register.php');
    exit();
}

/**
 * Accept form data for registering
 */
if ($action == 'register' && isPost) {
    sendHomeIfLoggedIn($currentUser);
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

/**
 * Process logout attempts
 */
if ($action == 'logout' && $isPost) {
    $_SESSION = array();
    session_destroy();
    header('Location: .');
}

?>
