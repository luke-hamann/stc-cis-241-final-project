<?php
/**
 * Title: Admin Controller
 */

require_once('./models/editForumViewModel.php');
require_once('./models/deletionViewModel.php');

/**
 * Display a form for creating a forum
 */
if ($action == 'addForum' && $isGet) {
    checkAdmin($currentUser);
    $model = new EditForumViewModel(null, 'Add', $currentUser);
    include('./views/admin/editForum.php');
    exit();
}

/**
 * Accept form data for creating a forum
 */
if ($action == 'addForum' && $isPost) {
    checkAdmin($currentUser);
    $forum = Forum::fromArray($_POST);
    $errors = $forum->getErrors();

    if (!ForumDB::isForumValid($forum)) {
        $errors[] = 'A forum with that name already exists.';
    }

    if (count($errors) > 0) {
        $model = new EditForumViewModel($forum, 'Add', $currentUser);
        include('./views/admin/editForum.php');
        exit();
    }
    ForumDB::addForum($forum);
    header('Location: ?action=forums');
}

/**
 * Display a form for editing a forum
 */
if ($action == 'editForum' && $isGet) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);
    $model = new EditForumViewModel($forum, 'Edit', $currentUser);
    include('./views/admin/editForum.php');
    exit();
}

/**
 * Accept form data for editing a forum
 */
if ($action == 'editForum' && $isPost) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    getObjectOr404('forum', $id);
    $forum = Forum::fromArray($_POST);
    $errors = $forum->getErrors();
    if (!ForumDB::isForumValid($forum)) {
        $errors = 'A forum with that name already exists.';
    }

    if (count($errors) > 0) {
        $model = new EditForumViewModel($forum, 'Edit', $currentUser);
        include('./views/admin/editForum.php');
        exit();
    }

    ForumDB::updateForum($forum);
    header('Location: ?action=forums');
}

/**
 * Display a form to confirm the deletion of a forum
 */
if ($action == 'deleteForum' && $isGet) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);

    $model = new DeletionViewModel(
        $forum->id,
        $forum->name,
        '?action=deleteForm&id=',
        '?action=forums',
        $currentUser
    );

    include('./views/shared/deleteObject.php');
    exit();
}

/**
 * Accept form data to confirm the deletion of a forum
 */
if ($action == 'deleteForum' && $isPost) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);
    ForumDB::deleteForum($forum);
    header('Location: ?action=forums');
}

/**
 * Display a form to confirm the deletion of a thread
 */
if ($action == 'deleteThread' && $isGet) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);

    $model = new DeletionViewModel(
        $id,
        $post->title,
        '?action=deleteThread&id=',
        '?action=post&id=' . $id,
        $currentUser
    );

    include('./views/shared/deleteObject.php');
    exit();
}

/**
 * Accept form data to confirm the deletion of a thread
 */
if ($action == 'deleteThread' && $isPost) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    PostDB::deletePost($post, true);
    header('Location: ?action=forum&id=' . $post->forumId);
}
