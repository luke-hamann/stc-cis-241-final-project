<?php
/**
 * Title: Post Controller
 * Purpose: To view, add, update, and delete posts and comments
 */

require_once('./models/viewModels/postViewModel.php');
require_once('./models/viewModels/editPostViewModel.php');
require_once('./models/viewModels/editCommentViewModel.php');
require_once('./models/viewModels/deletionViewModel.php');

/**
 * Display a form for creating a new post
 */
if ($action == 'new' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $model = new EditPostViewModel('Add', null, ForumDB::getForums(), $currentUser);
    include('./views/home/editPost.php');
    exit();
}

/**
 * Accept form data for publishing a new post
 */
if ($action == 'new' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $model = new EditPostViewModel(
        'Add', Post::fromArray($_POST), ForumDB::getForums(), $currentUser);

    if (!$model->isValid()) {
        $errors = $model->getErrors();
        include('./views/home/editPost.php');
        exit();
    }

    $model->post->userId = $currentUser->id;
    $id = PostDB::addPost($model->post);
    header('Location: ?action=post&id=' . $id);
}

/**
 * Display a form for editing a post
 */
if ($action == 'editPost' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    $model = new EditPostViewModel(
        'Edit', $post, ForumDB::getForums(), $currentUser);
    include('./views/home/editPost.php');
    exit();
}

/**
 * Accept form data for editing a post
 */
if ($action == 'editPost' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    getOwnedObjectOr404('post', $id, $currentUser);
    $post = Post::fromArray($_POST);
    $post->id = $id;
    $post->userId = $currentUser->id;

    $model = new EditPostViewModel('Edit', $post, ForumDB::getForums(), $currentUser);
    $model->validate();
    if (!$model->isValid()) {
        include('./views/home/editPost.php');
        exit();
    }
    PostDB::updatePost($post);
    header('Location: ?action=post&id=' . $post->id);
}

/**
 * Accept form data for confirming the deletion of a post
 */
if ($action == 'deletePost' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getOwnedObjectOr404('post', $id, $currentUser);
    PostDB::toggleDeletedPost($post);
    header('Location: ?action=post&id=' . $post->id);
}

/**
 * Accept form data for publishing a new comment
 */
if ($action == 'post' && $isPostRequest) {
    checkLoggedIn($currentUser);

    $id = FILTER_INPUT(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);

    $comment = Comment::fromArray($_POST);
    $comment->userId = $currentUser->id;

    $model = new PostViewModel($post, $currentUser, $comment);
    $model->validate();
    if (!$model->isValid()) {
        include('./views/home/post.php');
        exit();
    }

    CommentDB::addComment($comment);
    header('Location: ?action=post&id=' . $comment->postId);
}

/**
 * Display a form for editing a comment
 */
if ($action == 'editComment' && $isGetRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $comment = getObjectOr404('comment', $id);
    $model = new EditCommentViewModel($comment, $currentUser);
    include('./views/home/editComment.php');
    exit();
}

/**
 * Accept form data for editing a comment
 */
if ($action == 'editComment' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $comment = getOwnedObjectOr404('comment', $id, $currentUser);
    $content = FILTER_INPUT(INPUT_POST, 'content');
    $comment->content = $content;
    $model = new EditCommentViewModel($comment, $currentUser);

    $model->validate();
    if (!$model->isValid()) {
        include('./views/home/editComment.php');
        exit();
    }

    CommentDB::updateComment($comment);
    header('Location: ?action=post&id=' . $comment->postId);
}

/**
 * Display a form to confirm the deletion of a comment
 */
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

/**
 * Accept form data to accept deletion of a comment
 */
if ($action == 'deleteComment' && $isPostRequest) {
    checkLoggedIn($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $comment = getOwnedObjectOr404('comment', $id, $currentUser);
    CommentDB::deleteComment($id);
    header('Location: ?action=post&id=' . $comment->postId);
}
?>
