<?php include('./views/shared/header.php'); ?>

<div class="row my-5">
    <div class="col-md-6 offset-md-3">
        <h1>Reset Password</h1>
        <p>
            The password of
            <?php echo htmlspecialchars($model->selectedUser->name); ?>
            has been reset to
            <kbd><?php echo htmlspecialchars($model->selectedUser->password); ?></kbd>.
        </p>
        <p><a href="?action=users" class="btn btn-primary">OK</a></p>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
