<?php include('./views/shared/header.php'); ?>

<h1>Register</h1>

<form action="?action=register" method="post">
    <?php include('./views/shared/formErrors.php'); ?>
    <div>
        <label for="name">Username</label>
        <input type="text" name="name" id="name" value="<?php
            echo (isset($registerForm) ? $registerForm->name : ''); ?>" />
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" />
    </div>
    <div>
        <label for="passwordConfirm">Confirm Password</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" />
    </div>
    <div>
        <input type="submit" value="Register" />
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
