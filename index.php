<?php
/**
 * Title: Main Controller
 * Purpose: To be the entry point where controllers and models are imported,
 *          and the request context is prepared
 */

// Import the models
require_once('models/entities/forum.php');
require_once('models/entities/user.php');
require_once('models/entities/post.php');
require_once('models/entities/comment.php');
require_once('models/databases/_database.php');
require_once('models/databases/forumDB.php');
require_once('models/databases/userDB.php');
require_once('models/databases/postDB.php');
require_once('models/databases/commentDB.php');

// Start the session and get the current user
session_start();
if (!isset($_SESSION['userId'])) {
    $_SESSION['userId'] = 0;
}
$currentUser = UserDB::getUser($_SESSION['userId']);

// Get the action and request method
$action = FILTER_INPUT(INPUT_POST, 'action')
    ?? FILTER_INPUT(INPUT_GET, 'action') ?? 'home';
$isGetRequest = ($_SERVER['REQUEST_METHOD'] == 'GET');
$isPostRequest = ($_SERVER['REQUEST_METHOD'] == 'POST');

// Import the controllers
require_once('./controllers/_utilityFunctions.php');
require_once('./controllers/accountController.php');
require_once('./controllers/adminController.php');
require_once('./controllers/homeController.php');
require_once('./controllers/postController.php');

return404();

?>
