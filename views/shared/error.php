<?php
/**
 * Model: ErrorViewModel
 */
?>

<?php include('views/shared/header.php'); ?>

<div class="row mt-5">
    <div class="col-lg-6 offset-lg-3">
        <h1><?php echo htmlspecialchars($model->title); ?></h1>
        <div><?php echo htmlspecialchars($model->body); ?></div>
    </div>
</div>

<?php include('views/shared/footer.php'); ?>
