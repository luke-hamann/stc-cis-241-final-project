<?php
/**
 * Title: Main Controller
 */

require_once('models/entities/forum.php');
require_once('models/entities/user.php');
require_once('models/entities/post.php');
require_once('models/entities/comment.php');
require_once('models/databases/_database.php');
require_once('models/databases/forumDB.php');
require_once('models/databases/userDB.php');
require_once('models/databases/postDB.php');
require_once('models/databases/commentDB.php');

/**
 * Return a 404 Not Found Page
 */
function return404($currentUser) {
    $model = new ErrorViewModel('404 Not Found', 'That page does not exist.', $currentUser);
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
        return404($currentUser);
    }
}

/**
 * Attempt to get an object of a type and id and return a 404 if not found
 */
function getObjectOr404($type, $id) {
    if (!isset($id) || $id === false) {
        return404($currentUser);
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
            return404($currentUser);
    }

    if ($object === false) {
        return404($currentUser);
    }

    return $object;
}

/**
 * 
 */
function getOwnedObjectOr404($type, $id, $currentUser) {
    $object = getObjectOr404($type, $id);

    if (!isset($currentUser) || $object->userId != $currentUser->id) {
        return404($currentUser);
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

return404($currentUser);

?>
