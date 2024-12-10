<?php include('views/shared/header.php'); ?>

<div class="row">
    <h1 class="p-3 mt-3 mb-0"><?php echo htmlspecialchars($model->title); ?></h1>
    <div class="p-3"><?php echo htmlspecialchars($model->body); ?></div>
</div>

<?php include('views/shared/footer.php'); ?>
