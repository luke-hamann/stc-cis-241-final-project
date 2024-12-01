<?php include('./views/shared/header.php'); ?>

<div class="row">
    <div>
        <h1 class="p-3 m-3">
            <?php echo htmlspecialchars($model->user->name); ?>
        </h1>
        <?php if (isset($model->currentUser) && $model->user->id == $model->currentUser->id) : ?>
            <div class="p-3 m-3">
                <a href="?action=changePassword" class="btn btn-warning">Change Password</a>
            </div>
        <?php endif; ?>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="?action=user&id=<?php echo $model->user->id; ?>&mode=posts" class="nav-link <?php echo ($model->mode == 'posts' ? 'active' : ''); ?>">Posts</a>
            </li>
            <li class="nav-item">
                <a href="?action=user&id=<?php echo $model->user->id; ?>&mode=comments" class="nav-link <?php echo ($model->mode == 'comments' ? 'active' : ''); ?>">Comments</a>
            </li>
        </ul>
    </div>
    <?php if ($model->mode == 'posts') : ?>
        <p class="m-3">
            <?php echo count($model->posts) . ' post' . (count($model->posts) == 1 ? '' : 's'); ?>
        </p>
        <?php foreach ($model->posts as $post) : ?>
            <?php include('./views/shared/post.php'); ?>
        <?php endforeach; ?>
    <?php elseif ($model->mode == 'comments') : ?>
        <p class="m-3">
            <?php echo count($model->comments) . ' comment' . (count($model->comments) == 1 ? '' : 's'); ?>
        </p>
        <?php foreach ($model->comments as $comment) : ?>
            <?php include('./views/shared/comment.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
