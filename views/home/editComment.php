<?php include('./views/shared/header.php'); ?>

<h1>
    Edit comment
</h1>

<form action="?action=editComment" method="post">
    <input type="hidden" name="id" value="<?php echo $comment->id; ?>" />
    <?php include('./views/shared/formErrors.php'); ?>
    <div>
        <textarea name="content"><?php
            echo htmlspecialchars($comment->content); ?></textarea>
    </div>
    <div>
        <input type="submit" value="Save" />
        <a href="?action=post&id=<?php echo $comment->postId; ?>">
            Cancel
        </a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
