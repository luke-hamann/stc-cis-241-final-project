<?php
/**
 * Title: Home Controller
 */

if ($action == 'home' && $isGet) {
    $posts = PostDB::getRecentPosts();
    include('./views/home/home.php');
    exit();
}

if ($action == 'forums' && $isGet) {
    $forums = ForumDB::getForums();
    include('./views/home/forums.php');
    exit();
}
?>
