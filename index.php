<?php
/**
 * Title: Main Controller
 * Purpose: To serve as the application entry point where controllers and models are imported
 */

// Import the necessary models
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

// Get the action and request type
$action = FILTER_INPUT(INPUT_POST, 'action') ?? FILTER_INPUT(INPUT_GET, 'action') ?? 'home';
$isGetRequest = ($_SERVER['REQUEST_METHOD'] == 'GET');
$isPostRequest = ($_SERVER['REQUEST_METHOD'] == 'POST');

// Import the controllers
require('./controllers/_utilityFunctions.php');
require('./controllers/accountController.php');
require('./controllers/adminController.php');
require('./controllers/homeController.php');
require('./controllers/postController.php');

return404();

?>
