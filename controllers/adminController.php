<?php
/**
 * Title: Admin Controller
 */

require_once('./models/viewModels/editForumViewModel.php');
require_once('./models/viewModels/deletionViewModel.php');
require_once('./models/viewModels/resetPasswordResultViewModel.php');

/**
 * Display a form for creating a forum
 */
if ($action == 'addForum' && $isGetRequest) {
    checkAdmin($currentUser);
    $model = new EditForumViewModel(null, 'Add', $currentUser);
    include('./views/admin/editForum.php');
    exit();
}

/**
 * Accept form data for creating a forum
 */
if ($action == 'addForum' && $isPostRequest) {
    checkAdmin($currentUser);
    $forum = Forum::fromArray($_POST);
    $model = new EditForumViewModel($forum, 'Add', $currentUser);

    if (!ForumDB::isForumValid($forum)) {
        $model->pushError('A forum with that name already exists.');
    }

    if (!$model->isValid()) {
        include('./views/admin/editForum.php');
        exit();
    }
    ForumDB::addForum($forum);
    header('Location: ?action=forums');
}

/**
 * Display a form for editing a forum
 */
if ($action == 'editForum' && $isGetRequest) {
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
if ($action == 'editForum' && $isPostRequest) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    getObjectOr404('forum', $id);
    $forum = Forum::fromArray($_POST);
    $model = new EditForumViewModel($forum, 'Edit', $currentUser);

    $model->validate();
    if (!ForumDB::isForumValid($forum)) {
        $errors = 'A forum with that name already exists.';
    }

    if (!$model->isValid()) {
        include('./views/admin/editForum.php');
        exit();
    }

    ForumDB::updateForum($forum);
    header('Location: ?action=forums');
}

/**
 * Display a form to confirm the deletion of a forum
 */
if ($action == 'deleteForum' && $isGetRequest) {
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
if ($action == 'deleteForum' && $isPostRequest) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $forum = getObjectOr404('forum', $id);
    ForumDB::deleteForum($forum);
    header('Location: ?action=forums');
}

/**
 * Display a form to confirm the deletion of a thread
 */
if ($action == 'deleteThread' && $isGetRequest) {
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
if ($action == 'deleteThread' && $isPostRequest) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $post = getObjectOr404('post', $id);
    PostDB::deletePost($post, true);
    header('Location: ?action=forum&id=' . $post->forumId);
}

/**
 * Display a form to confirm the deletion of a user
 */
if ($action == 'deleteUser' && $isGetRequest) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $user = getObjectOr404('user', $id);
    if ($user->isAdmin || $user->isGhost) {
        return404();
    }

    $model = new DeletionViewModel(
        $id,
        $user->name,
        '?action=deleteUser&id=',
        '?action=users',
        $currentUser
    );

    include('./views/shared/deleteObject.php');
    exit();
}

/**
 * Accept form data to confirm the deletion of a user
 */
if ($action == 'deleteUser' && $isPostRequest) {
    checkAdmin($currentUser);
    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $user = getObjectOr404('user', $id);
    if ($user->isAdmin || $user->isGhost) {
        return404();
    }

    UserDB::markUserAsGhost($user);
    header('Location: ?action=users');
}

/**
 * Accept form data for resetting a user's password
 */
if ($action == 'resetPassword' && $isPostRequest) {
    checkAdmin($currentUser);
    $confirm = FILTER_INPUT(INPUT_POST, 'confirm');
    if ($confirm === null) {
        header('Location: ?action=users');
    }

    $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $user = getObjectOr404('user', $id);
    if ($user->name == 'ghost') {
        return404();
    }

    $user = UserDB::resetUserPassword($user);

    $model = new ResetPasswordResultViewModel($user, $currentUser);
    include('./views/admin/resetPasswordResult.php');
    exit();
}
