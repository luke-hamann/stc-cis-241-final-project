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

function return404() {
    $title = '404 Not Found';
    $body = 'That page does not exist.';
    include('views/shared/error.php');
    exit();
}

session_start();
if (!isset($_SESSION['userId'])) {
    $_SESSION['userId'] = 0;
}
$currentUser = UserDB::getUser($_SESSION['userId']);

$action = FILTER_INPUT(INPUT_POST, 'action') ?? FILTER_INPUT(INPUT_GET, 'action') ?? 'home';

require('./controllers/accountController.php');
require('./controllers/homeController.php');

return404();

?>
