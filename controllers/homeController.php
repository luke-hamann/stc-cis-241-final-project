<?php
/**
 * Title: Home Controller
 */

/**
 * Display the home page with recent posts from all forums
 */
if ($action == 'home' && $isGet) {
    $posts = PostDB::getRecentPosts();
    include('./views/home/home.php');
    exit();
}

/**
 * Display the list of all forums
 */
if ($action == 'forums' && $isGet) {
    $forums = ForumDB::getForums();
    include('./views/home/forums.php');
    exit();
}

/**
 * Display posts within a given forum
 */
if ($action == 'forum' && $isGet) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);
    include('./views/home/forum.php');
    exit();
}

/**
 * Display a given post with its comments
 */
if ($action == 'post' && $isGet) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    include('./views/home/post.php');
    exit();
}

?>
