<?php
/**
 * Title: Post Controller
 * Purpose: To view, add, update, and delete posts and comments
 */

/**
 * Display a form for creating a new post
 */
if ($action == 'new' && $isGet) {
    checkLoggedIn($currentUser);
    $mode = 'Add';
    $forums = ForumDB::getForums();
    include('./views/home/editPost.php');
    exit();
}

/**
 * Accept form data for publishing a new post
 */
if ($action == 'new' && $isPost) {
    checkLoggedIn($currentUser);

    $post = Post::fromArray($_POST);
    if (!$post->isValid()) {
        $mode = 'Add';
        $forums = ForumDB::getForums();
        $errors = $post->getErrors();
        include('./views/home/editPost.php');
        exit();
    }

    $post->userId = $currentUser->id;
    $id = PostDB::addPost($post);
    header('Location: ?action=post&id=' . $id);
}

/**
 * Display a form for editing a post
 */
if ($action == 'editPost' && $isGet) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    $mode = 'Edit';
    $forums = ForumDB::getForums();
    include('./views/home/editPost.php');
    exit();
}

/**
 * Accept form data for editing a post
 */
if ($action == 'editPost' && $isPost) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    $post = Post::fromArray($_POST);
    $post->id = $id;
    $post->userId = $currentUser->id;
    if (!$post->isValid()) {
        $mode = 'Edit';
        $forums = ForumDB::getForums();
        $errors = $post->getErrors();
        include('./views/home/editPost.php');
        exit();
    }
    PostDB::updatePost($post);
    header('Location: ?action=post&id=' . $post->id);
}

/**
 * Display a form for confirming the deletion of a post
 */
if ($action == 'deletePost' && $isGet) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    $object = $post;
    include('./views/home/deleteObject.php');
    exit();
}

/**
 * Accept form data for confirming the deletion of a post
 */
if ($action == 'deletePost' && $isPost) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    PostDB::deletePost($post);
    header('Location: ?action=forum&id=' . $post->forumId);
}

/**
 * Accept form data for publishing a new comment
 */
if ($action == 'post' && $isPost) {
    checkLoggedIn($currentUser);

    $id = FILTER_INPUT(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    $comment = Comment::fromArray($_POST);
    if (!$comment->isValid()) {
        include('./views/home/post.php');
        exit();
    }

    $comment->userId = $currentUser->id;
    CommentDB::addComment($comment);
    header('Location: ?action=post&id=' . $comment->postId);
}

/**
 * Display a form for editing a comment
 */
if ($action == 'editComment' && $isGet) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $comment = getObjectOr404('comment', $id);
    include('./views/home/editComment.php');
    exit();
}

/**
 * Accept form data for editing a comment
 */
if ($action == 'editComment' && $isPost) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $comment = getObjectOr404('comment', $id);

    if ($comment->userId != $currentUser->id) {
        return404();
    }

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

/**
 * Display a form to confirm the deletion of a comment
 */
if ($action == 'deleteComment' && $isGet) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $object = getObjectOr404('comment', $id);
    include('./views/home/deleteObject.php');
    exit();
}

/**
 * Accept form data to accept deletion of a comment
 */
if ($action == 'deleteComment' && $isPost) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $comment = getObjectOr404('comment', $id);

    if ($comment->userId != $currentUser->id) {
        return404();
    }

    CommentDB::deleteComment($id);
    header('Location: ?action=post&id=' . $comment->postId);
}
?>
