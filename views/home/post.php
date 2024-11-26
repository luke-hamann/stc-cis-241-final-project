<?php include('./views/shared/header.php'); ?>

<?php include('./views/shared/post.php'); ?>

<h2>Comments</h2>

<?php if (isset($currentUser)) : ?>
    <form action="?action=post" method="post">
        <?php include('./views/shared/formErrors.php'); ?>
        <input type="hidden" name="postId" value="<?php echo $post->id; ?>" />
        <div>
            <textarea name="content"><?php
                echo (isset($comment) ? $comment->content : ''); ?></textarea>
        </div>
        <div>
            <input type="submit" value="Comment" />
        </div>
    </form>
<?php endif; ?>

<p>
    <?php echo count($post->comments) . ' comment' .
        (count($post->comments) == 1 ? '' : 's'); ?>
</p>

<?php if (count($post->comments) > 0) : ?>
    <?php foreach ($post->comments as $comment) : ?>
        <?php include('./views/shared/comment.php'); ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php include('./views/shared/footer.php'); ?>
