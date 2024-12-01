<?php include('views/shared/header.php'); ?>

<div class="row my-5">
    <div class="col-md-6 offset-md-3">
        <h1><?php echo htmlspecialchars($model->title); ?></h1>
        <div><?php echo htmlspecialchars($model->body); ?></div>
    </div>
</div>

<?php include('views/shared/footer.php'); ?>
