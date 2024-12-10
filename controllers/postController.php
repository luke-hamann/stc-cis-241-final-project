<?php
/**
 * Title: Post Controller
 * Purpose: To view, add, update, and delete posts and comments
 */

require_once('./models/viewModels/postViewModel.php');
require_once('./models/viewModels/postEditViewModel.php');
require_once('./models/viewModels/commentEditViewModel.php');
require_once('./models/viewModels/deletionViewModel.php');

// Display a given post with its comments
if ($action == 'post' && $isGetRequest) {
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    $model = new PostViewModel($post, $currentUser, null);
    include('./views/post/post.php');
    exit();
}

// Accept form data for publishing a new comment
if ($action == 'post' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    $comment = Comment::fromArray($_POST);
    $comment->userId = $currentUser->id;

    $model = new PostViewModel($post, $currentUser, $comment);
    $model->validate();
    if (!$model->isValid()) {
        include('./views/post/post.php');
        exit();
    }

    CommentDB::addComment($comment);
    header('Location: ?action=post&id=' . $comment->postId);
}

// Display a form for creating a new post
if ($action == 'new' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $model = new PostEditViewModel(
        'Add', null, ForumDB::getForums(), $currentUser);
    include('./views/post/postEdit.php');
    exit();
}

// Accept form data for creating a new post
if ($action == 'new' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $model = new PostEditViewModel(
        'Add', Post::fromArray($_POST), ForumDB::getForums(), $currentUser);
    $model->post->userId = $currentUser->id;

    $model->validate();
    if (!$model->isValid()) {
        include('./views/post/postEdit.php');
        exit();
    }

    $id = PostDB::addPost($model->post);
    header('Location: ?action=post&id=' . $id);
}

// Display a form for editing a post
if ($action == 'editPost' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    $model = new PostEditViewModel(
        'Edit', $post, ForumDB::getForums(), $currentUser);
    include('./views/post/postEdit.php');
    exit();
}

// Accept form data for editing a post
if ($action == 'editPost' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    getOwnedObjectOr404('post', $id, $currentUser);
    $post = Post::fromArray($_POST);
    $post->id = $id;
    $post->userId = $currentUser->id;

    $model = new PostEditViewModel(
        'Edit', $post, ForumDB::getForums(), $currentUser);
    $model->validate();
    if (!$model->isValid()) {
        include('./views/post/postEdit.php');
        exit();
    }

    PostDB::updatePost($post);
    header('Location: ?action=post&id=' . $post->id);
}

// Accept form data for toggling the visibility of a post
if ($action == 'togglePostVisibility' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    PostDB::togglePostVisibility($post);
    header('Location: ?action=post&id=' . $post->id);
}

// Display a form for editing a comment
if ($action == 'editComment' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $comment = getOwnedObjectOr404('comment', $id, $currentUser);
    $model = new CommentEditViewModel($comment, $currentUser);
    include('./views/post/commentEdit.php');
    exit();
}

// Accept form data for editing a comment
if ($action == 'editComment' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $comment = getOwnedObjectOr404('comment', $id, $currentUser);
    $content = FILTER_INPUT(INPUT_POST, 'content');
    $comment->content = $content;
    $model = new CommentEditViewModel($comment, $currentUser);

    $model->validate();
    if (!$model->isValid()) {
        include('./views/post/commentEdit.php');
        exit();
    }

    CommentDB::updateComment($comment);
    header('Location: ?action=post&id=' . $comment->postId);
}

// Display a form to confirm the deletion of a comment
if ($action == 'deleteComment' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $comment = getOwnedObjectOr404('comment', $id, $currentUser);
    $model = new DeletionViewModel(
        $comment->id,
        $comment->content,
        '?action=deleteComment&id=',
        '?action=post&id=' . $comment->postId,
        $currentUser
    );
    include('./views/shared/deleteObject.php');
    exit();
}

// Accept form data to confirm the deletion of a comment
if ($action == 'deleteComment' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $comment = getOwnedObjectOr404('comment', $id, $currentUser);
    CommentDB::deleteComment($id);
    header('Location: ?action=post&id=' . $comment->postId);
}

?>
