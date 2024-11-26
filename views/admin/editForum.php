<?php include('./views/shared/header.php'); ?>

<?php
if ($model->mode == 'Add') {
    $formAction = '?action=addForum';
} else if ($model->mode == 'Edit') {
    $formAction = '?action=editForum&id=' . $forum->id;
}
?>

<h1>
    <?php echo $model->mode; ?> Forum
</h1>

<form action="<?php echo $formAction; ?>" method="post">
    <input type="hidden" name="id"
        value="<?php echo (isset($model->forum) ? $model->forum->id : '0'); ?>" />
    <?php include './views/shared/formErrors.php'; ?>
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name"
            value="<?php echo (isset($model->forum) ? $model->forum->name : ''); ?>" />
    </div>
    <div>
        <input type="submit" value="Submit" />
        <a href="?action=forums">Cancel</a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
