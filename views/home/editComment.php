<?php include('./views/shared/header.php'); ?>

<h1>
    Edit Comment
</h1>

<form action="?action=editComment" method="post">
    <input type="hidden" name="id" value="<?php echo $model->comment->id; ?>" />
    <?php include('./views/shared/formErrors.php'); ?>
    <div>
        <textarea name="content"><?php
            echo htmlspecialchars($model->comment->content); ?></textarea>
    </div>
    <div>
        <input type="submit" value="Save" />
        <a href="?action=post&id=<?php echo $model->comment->postId; ?>">
            Cancel
        </a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
