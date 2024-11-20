<?php include('./views/shared/header.php'); ?>

<h1>
    Confirm Deletion
</h1>

<form action="?action=deleteComment" method="post">
    <input type="hidden" name="id" value="<?php echo $comment->id; ?>" />
    <div>
        Are you sure you want to delete "<?php
            echo htmlspecialchars(substr($comment->content, 0, 20)); ?>"?
    </div>
    <div>
        <input type="submit" value="Yes" />
        <a href="?action=post&id=<?php echo $comment->postId; ?>">
            No
        </a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
