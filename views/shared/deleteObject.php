<?php
/**
 * Model: DeletionViewModel
 */
?>

<?php include('./views/shared/header.php'); ?>

<h1>
    Confirm Deletion
</h1>

<form action="<?php echo $model->formActionStub . $model->id; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
    <div>
        Are you sure you want to delete "<?php echo $model->summary; ?>"?
    </div>
    <div>
        <input type="submit" value="Yes" />
        <a href="<?php echo $model->cancelUrl; ?>">
            No
        </a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
