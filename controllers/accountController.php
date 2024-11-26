<?php
/**
 * Title: Account Controller
 * Purpose: To manage user sessions, including logins, logouts, and registrations
 */

require_once('./models/viewModels/LoginViewModel.php');
require_once('./models/viewModels/RegisterViewModel.php');

/**
 * Display the login form
 */
if ($action == 'login' && $isGetRequest) {
    sendHomeIfLoggedIn($currentUser);
    $model = new LoginViewModel('', '', $currentUser);
    include('./views/account/login.php');
    exit();
}

/**
 * Accept form data for logging in
 */
if ($action == 'login' && $isPostRequest) {
    sendHomeIfLoggedIn($currentUser);

    $model = LoginViewModel::fromArray($_POST);
    $model->validate();
    if (!$model->isValid()) {
        include('./views/account/login.php');
        exit();
    }

    $user = UserDB::loginUser($model->name, $model->password);
    if (!isset($user)) {
        $model->pushError('Invalid credentials');
        include('./views/account/login.php');
        exit();
    }

    $_SESSION['userId'] = $user->id;
    header('Location: .');
}

/**
 * Display the registration form
 */
if ($action == 'register' && $isGetRequest) {
    sendHomeIfLoggedIn($currentUser);
    $model = new RegisterViewModel('', '', '');
    include('./views/account/register.php');
    exit();
}

/**
 * Accept form data for registering
 */
if ($action == 'register' && $isPostRequest) {
    sendHomeIfLoggedIn($currentUser);
    $model = RegisterViewModel::fromArray($_POST);
    $model->validate();
    if (UserDB::getUserByName($model->name) !== null) {
        $model->unshiftError('Username is taken.');
    }

    if (!$model->isValid()) {
        include('./views/account/register.php');
        exit();
    }

    $userId = UserDB::addUser($model->getUser());
    $_SESSION['userId'] = $userId;
    header('Location: .');
}

/**
 * Process logout attempts
 */
if ($action == 'logout' && $isPostRequest) {
    $_SESSION = array();
    session_destroy();
    header('Location: .');
}

?>
