<?php include('./views/shared/header.php'); ?>

<?php
if ($model->mode == 'Add') {
    $formAction = '?action=addForum';
} else if ($model->mode == 'Edit') {
    $formAction = '?action=editForum&id=' . $forum->id;
}
?>

<div class="row my-5">
    <div class="col-md-4 offset-md-4">
        <form action="<?php echo $formAction; ?>" method="post">
            <h1><?php echo $model->mode; ?> Forum</h1>
            <input type="hidden" name="id" value="<?php echo (isset($model->forum) ? $model->forum->id : '0'); ?>" />
            <?php include('./views/shared/formErrors.php'); ?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="<?php echo (isset($model->forum) ? htmlspecialchars($model->forum->name) : ''); ?>" class="form-control" autocomplete="off" />
            </div>
            <div class="text-center">
                <input type="submit" value="Submit" class="btn btn-primary" />
                <a href="?action=forums" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
