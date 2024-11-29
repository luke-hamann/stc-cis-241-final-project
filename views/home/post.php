<?php include('./views/shared/header.php'); ?>

<div class="container mt-5">
    <?php include('./views/shared/post.php'); ?>

    <h2 class="mt-3 mx-3 mb-1">Comments</h2>

    <div class="ms-3">
        <?php echo count($post->comments) . ' comment' . (count($post->comments) == 1 ? '' : 's'); ?>
    </div>

    <?php if (isset($currentUser)) : ?>
        <form action="?action=post" method="post" class="m-3">
            <?php include('./views/shared/formErrors.php'); ?>
            <input type="hidden" name="postId" value="<?php echo $post->id; ?>" />
            <div class="mb-3">
                <textarea name="content" class="form-control"><?php echo (isset($comment) ? $comment->content : ''); ?></textarea>
            </div>
            <div>
                <input type="submit" value="Comment" class="btn btn-primary" />
            </div>
        </form>
    <?php endif; ?>

    <?php if (count($post->comments) > 0) : ?>
        <?php foreach ($post->comments as $comment) : ?>
            <?php include('./views/shared/comment.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
