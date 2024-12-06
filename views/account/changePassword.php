<?php include('./views/shared/header.php'); ?>

<div class="row my-5">
    <div class="col-sm-4 offset-sm-4">
        <h1>Change Password</h1>
        <form action="?action=changePassword" method="post">
            <?php include('./views/shared/formErrors.php'); ?>
            <div class="mb-3">
                <label for="passwordOld" class="form-label">Old Password</label>
                <input type="password" name="passwordOld" id="passwordOld" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="passwordNew" class="form-label">New Password</label>
                <input type="password" name="passwordNew" id="passwordNew" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="passwordNewConfirm" class="form-label">Confirm New Password</label>
                <input type="password" name="passwordNewConfirm" id="passwordNewConfirm" class="form-control" />
            </div>
            <div class="text-center">
                <input type="submit" value="Submit" class="btn btn-primary" />
                <a href="?action=user&id=<?php echo $model->currentUser->id; ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
