<?php include('./views/shared/header.php'); ?>

<div class="row">
    <div class="col-md-4 offset-md-4">
        <form action="?action=login" method="post" class="mt-5">
            <h1>Login</h1>
            <?php include('./views/shared/formErrors.php'); ?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" autocomplete="off"
                    value="<?php echo (isset($model) ? htmlspecialchars($model->name) : ''); ?>"
                    class="form-control" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <div class="text-center">
                <input type="submit" value="Login" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
