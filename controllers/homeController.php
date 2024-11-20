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

if ($action == 'forum' && $isGet) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false) return404();
    $forum = ForumDB::getForum($id);
    if ($forum === null) return404();
    include('./views/home/forum.php');
    exit();
}

if ($action == 'post') {
    if ($isGet) {
        $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false) return404();
        $post = PostDB::getPost($id);
        if ($post === null) return404();
        include('./views/home/post.php');
        exit();
    } else if ($isPost) {
        $comment = Comment::fromArray($_POST);
        if (!$comment->isValid()) {
            $post = PostDB::getPost($id);
            include('./views/home/post.php');
            exit();
        }
        $comment->userId = $currentUser->id;
        CommentDB::addComment($comment);
        header('Location: ?action=post&id=' . $comment->postId);
    }
}

if ($action == 'new') {
    if (!isset($currentUser)) {
        header('Location: ?action=login');
    }

    if ($isGet) {
        $forums = ForumDB::getForums();
        include('./views/home/new.php');
        exit();
    } else if ($isPost) {
        $post = Post::fromArray($_POST);
        if (!$post->isValid()) {
            $forums = ForumDB::getForums();
            $errors = $post->getErrors();
            include('./views/home/new.php');
            exit();
        }

        $post->userId = $currentUser->id;
        $id = PostDB::addPost($post);
        header('Location: ?action=post&id=' . $id);
    }
}

if ($action == 'editComment' || $action == 'deleteComment') {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT) ??
        FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT) ??
        false;
    if ($id === false) return404();
    $comment = CommentDB::getComment($id);
    if ($comment === false || $comment->userId != $currentUser->id) {
        return404();
    }
}

if ($action == 'editComment') {
    if ($isGet) {
        include('./views/home/editComment.php');
        exit();
    } else if ($isPost) {
        $content = FILTER_INPUT(INPUT_POST, 'content');
        $comment->content = $content;

        if (!$comment->isValid()) {
            $errors = $comment->getErrors();
            include('./views/home/editComment.php');
            exit();
        }

        CommentDB::updateComment($comment);
        header('Location: ?action=post&id=' . $comment->postId);
    }
}

if ($action == 'deleteComment') {
    if ($isGet) {
        include('./views/home/deleteComment.php');
        exit();
    } else if ($isPost) {
        CommentDB::deleteComment($id);
        header('Location: ?action=post&id=' . $comment->postId);
    }
}
?>
