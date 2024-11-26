<?php include('./views/shared/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($model->user->name); ?>
</h1>

<p>
    <a href="?action=user&id=<?php echo $model->user->id; ?>&mode=posts">Posts</a>
    <a href="?action=user&id=<?php echo $model->user->id; ?>&mode=comments">Comments</a>
</p>

<?php if ($model->mode == 'posts') : ?>
    <h2>Posts</h2>
    <p>
        <?php echo count($model->posts) . ' post' .
            (count($model->posts) == 1 ? '' : 's'); ?>
    </p>
    <?php foreach ($model->posts as $post) : ?>
        <?php include('./views/shared/post.php'); ?>
    <?php endforeach; ?>
<?php else : ?>
    <h2>Comments</h2>
    <p>
        <?php echo count($model->comments) . ' comment' .
                (count($model->comments) == 1 ? '' : 's'); ?>
    </p>
    <?php foreach ($model->comments as $comment) : ?>
        <div>
            <?php include('./views/shared/comment.php'); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include('./views/shared/footer.php'); ?>
