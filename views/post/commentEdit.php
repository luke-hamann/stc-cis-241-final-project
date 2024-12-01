<?php include('./views/shared/header.php'); ?>

<div class="row">
    <div class="col-md-6 offset-md-3 my-5">
        <form action="?action=editComment" method="post">
            <h1 class="mb-3">Edit Comment</h1>
            <input type="hidden" name="id" value="<?php echo $model->comment->id; ?>" />
            <?php include('./views/shared/formErrors.php'); ?>
            <div class="mb-3">
                <textarea name="content" rows="5" class="form-control"><?php echo htmlspecialchars($model->comment->content); ?></textarea>
            </div>
            <div class="text-center">
                <input type="submit" value="Save" class="btn btn-primary" />
                <a href="?action=post&id=<?php echo $model->comment->postId; ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
