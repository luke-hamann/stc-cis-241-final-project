<?php
/**
 * Title: Controller Utility Functions
 * Purpose: To provide a library of convenience functions for all controller actions
 */

require_once('./models/viewModels/errorViewModel.php');

// Return a 404 Not Found Page
function return404() {
    global $currentUser;
    $model = new ErrorViewModel(
        '404 Not Found', 'That page does not exist.', $currentUser);
    include('views/shared/error.php');
    exit();
}

// Redirect the user to the login page if they are not logged in
function checkLoggedIn($currentUser) {
    if (!isset($currentUser)) {
        header('Location: ?action=login');
    }
}

// Verify that the user is an admin or return 404
function checkAdmin($currentUser) {
    checkLoggedIn($currentUser);
    if (!$currentUser->isAdmin) {
        return404();
    }
}

// Redirect the user to the home page if they are already logged in
function sendHomeIfLoggedIn($currentUser) {
    if (isset($currentUser)) {
        header('Location: .');
    }
}

// Attempt to get an object of a type and id and return a 404 if not found
function getObjectOr404($type, $id) {
    if (!isset($id) || $id === false) {
        return404();
    }

    switch ($type) {
        case 'forum':
            $object = ForumDB::getForum($id);
            break;
        case 'user':
            $object = UserDB::getUser($id);
            break;
        case 'post':
            $object = PostDB::getPost($id);
            break;
        case 'comment':
            $object = CommentDB::getComment($id);
            break;
        default:
            return404();
    }

    if (!isset($object)) {
        return404();
    }

    return $object;
}

// Attempt to get an object of a type and id that is owned by a user
// or return a 404 if not found
function getOwnedObjectOr404($type, $id, $currentUser) {
    $object = getObjectOr404($type, $id);

    $allowed = isset($currentUser) &&
        ($currentUser->isAdmin || $object->userId == $currentUser->id);

    if ($allowed) {
        return $object;
    } else {
        return404();
    }
}

?>
