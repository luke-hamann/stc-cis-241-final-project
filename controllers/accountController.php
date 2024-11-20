<?php
/**
 * Title: Account Controller
 * Purpose: To manage user sessions, including logins, logouts, and registrations
 */

require_once('./models/loginForm.php');
require_once('./models/registerForm.php');

/**
 * Render the login form and process attempted logins
 */
if ($action == 'login') {
    if (isset($currentUser)) {
        header('Location: .');
    }

    if ($isGet) {
        include('./views/account/login.php');
        exit();
    } else if ($isPost) {
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
}

/**
 * Render the registration form and process attempted registrations
 */
if ($action == 'register') {
    if (isset($currentUser)) {
        header('Location: .');
    }

    if ($isGet) {
        include('./views/account/register.php');
        exit();
    } else if ($isPost) {
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
