<?php include('./views/shared/header.php'); ?>

<div class="row my-5">
    <div class="col-md-4 offset-md-4">
        <form action="?action=register" method="post">
            <h1>Register</h1>
            <?php include('./views/shared/formErrors.php'); ?>
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" name="name" id="name" autocomplete="off"
                    value="<?php echo (isset($model) ? htmlspecialchars($model->name) : ''); ?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="passwordConfirm" class="form-label">Confirm Password</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" />
            </div>
            <div class="text-center">
                <input type="submit" value="Register" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
