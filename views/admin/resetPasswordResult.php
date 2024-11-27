<?php include('./views/shared/header.php'); ?>

<h1>
    Reset Password
</h1>

<p>
    The password of
    <?php echo htmlspecialchars($model->selectedUser->name); ?>
    has been reset to
    <kbd><?php echo htmlspecialchars($model->selectedUser->password); ?></kbd>.
</p>

<p>
    <a href="?action=users" class="btn btn-primary">OK</a>
</p>

<?php include('./views/shared/footer.php'); ?>
