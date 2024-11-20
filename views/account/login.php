<?php include('./views/shared/header.php'); ?>

<h1>Login</h1>

<form action="?action=login" method="post">
    <?php include ('./views/shared/formErrors.php'); ?>
    <div>
        <label for="name">Name</label>
        <input type="text" name="name"
            value="<?php echo (
                isset($loginForm) ? htmlspecialchars($loginForm->name) : ''); ?>" />
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" />
    </div>
    <div>
        <input type="submit" value="Login" />
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
