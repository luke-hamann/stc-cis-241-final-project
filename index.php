<?php
/**
 * Title: Main Controller
 */

require_once('models/forum.php');
require_once('models/user.php');
require_once('models/post.php');
require_once('models/comment.php');
require_once('models/database.php');
require_once('models/forumDB.php');
require_once('models/userDB.php');
require_once('models/postDB.php');
require_once('models/commentDB.php');

/**
 * Return a 404 Not Found Page
 */
function return404() {
    global $currentUser;
    $title = '404 Not Found';
    $body = 'That page does not exist.';
    include('views/shared/error.php');
    exit();
}

/**
 * Redirect the user to the login page if they are not logged in
 */
function checkLoggedIn($currentUser) {
    if (!isset($currentUser)) {
        header('Location: ?action=login');
    }
}

/**
 * Verify that a user is an admin
 */
function checkAdmin($currentUser) {
    checkLoggedIn($currentUser);
    if (!$currentUser->admin) {
        return404();
    }
}

/**
 * Attempt to get an object of a type and id and return a 404 if not found
 */
function getObjectOr404($type, $id) {
    if (!isset($id) || $id === false) {
        return404();
    }

    switch ($type) {
        case 'forum':
            $object = ForumDB::getForum($id);
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

    if ($object === false) {
        return404();
    }

    return $object;
}

/**
 * 
 */
function getOwnedObjectOr404($type, $id, $currentUser) {
    $object = getObjectOr404($type, $id);

    if (!isset($currentUser) || $object->userId != $currentUser->id) {
        return404();
    }

    return $object;
}

session_start();
if (!isset($_SESSION['userId'])) {
    $_SESSION['userId'] = 0;
}
$currentUser = UserDB::getUser($_SESSION['userId']);

$action = FILTER_INPUT(INPUT_POST, 'action') ?? FILTER_INPUT(INPUT_GET, 'action') ?? 'home';
$isGet = ($_SERVER['REQUEST_METHOD'] == 'GET');
$isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');

require('./controllers/adminController.php');
require('./controllers/accountController.php');
require('./controllers/homeController.php');
require('./controllers/postController.php');

return404();

?>
