<?php include('./views/shared/header.php'); ?>

<div class="row my-5">
    <?php $post = $model->post; ?>
    <?php include('./views/shared/post.php'); ?>
    <h2 class="my-3">Comments</h2>
    <div class="p-3">
        <?php echo count($model->post->comments) . ' comment' . (count($model->post->comments) == 1 ? '' : 's'); ?>
    </div>
    <?php if (isset($model->currentUser)) : ?>
        <form action="?action=post" method="post" class="p-3">
            <?php include('./views/shared/formErrors.php'); ?>
            <input type="hidden" name="postId" value="<?php echo $model->post->id; ?>" />
            <div class="mb-3">
                <textarea name="content" class="form-control"><?php echo (isset($model->comment) ? $model->comment->content : ''); ?></textarea>
            </div>
            <div>
                <input type="submit" value="Comment" class="btn btn-primary" />
            </div>
        </form>
    <?php endif; ?>
    <?php foreach ($model->post->comments as $comment) : ?>
        <?php include('./views/shared/comment.php'); ?>
    <?php endforeach; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
