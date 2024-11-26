<?php
/**
 * Title: Home Controller
 */

require_once('./models/homeViewModel.php');
require_once('./models/forumsViewModel.php');
require_once('./models/forumViewModel.php');
require_once('./models/postViewModel.php');

/**
 * Display the home page with recent posts from all forums
 */
if ($action == 'home' && $isGet) {
    $model = new HomeViewModel(PostDB::getRecentPosts(), $currentUser);
    include('./views/home/home.php');
    exit();
}

/**
 * Display the list of all forums
 */
if ($action == 'forums' && $isGet) {
    $model = new ForumsViewModel(ForumDB::getForums(), $currentUser);
    include('./views/home/forums.php');
    exit();
}

/**
 * Display posts within a given forum
 */
if ($action == 'forum' && $isGet) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);
    $model = new ForumViewModel($forum, $currentUser);
    include('./views/home/forum.php');
    exit();
}

/**
 * Display a given post with its comments
 */
if ($action == 'post' && $isGet) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    $model = new PostViewModel($post, $currentUser);
    include('./views/home/post.php');
    exit();
}

?>
