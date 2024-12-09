<?php
/**
 * Title: Home Controller
 * Purpose: To display the home page, forums and forum pages, and users and user pages
 */

require_once('./models/viewModels/homeViewModel.php');
require_once('./models/viewModels/forumsViewModel.php');
require_once('./models/viewModels/forumViewModel.php');
require_once('./models/viewModels/usersViewModel.php');
require_once('./models/viewModels/userViewModel.php');
require_once('./models/viewModels/postViewModel.php');

// Display the home page with recent posts from all forums
if ($action == 'home' && $isGetRequest) {
    $model = new HomeViewModel(PostDB::getRecentPosts(), $currentUser);
    include('./views/home/home.php');
    exit();
}

// Display the list of all forums
if ($action == 'forums' && $isGetRequest) {
    $model = new ForumsViewModel(ForumDB::getForums(), $currentUser);
    include('./views/home/forums.php');
    exit();
}

// Display posts within a given forum
if ($action == 'forum' && $isGetRequest) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);
    $model = new ForumViewModel($forum, $currentUser);
    include('./views/home/forum.php');
    exit();
}

// Display the list of all users
if ($action == 'users' && $isGetRequest) {
    $model = new UsersViewModel(UserDB::getUsers(), $currentUser);
    include('./views/home/users.php');
    exit();
}

// Display a single user and all their posts or comments
if ($action == 'user' && $isGetRequest) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $user = getObjectOr404('user', $id);

    if ($user->isGhost) {
        return404();
    }

    $mode = FILTER_INPUT(INPUT_GET, 'mode');
    if ($mode === null) {
        $mode = 'posts';
    } else if ($mode !== 'posts' && $mode !== 'comments') {
        return404();
    }

    $posts = [];
    $comments = [];
    if ($mode == 'posts') {
        $posts = PostDB::getUserPosts($id);
    } else {
        $comments = CommentDB::getUserComments($id);
    }

    $model = new UserViewModel($user, $mode, $posts, $comments, $currentUser);
    include('./views/home/user.php');
    exit();
}

?>
