<?php
/**
 * Model: ChangePasswordViewModel
 */
?>

<?php include('./views/shared/header.php'); ?>

<h1>Change Password</h1>

<form action="?action=changePassword" method="post">
    <?php include ('./views/shared/formErrors.php'); ?>
    <div>
        <label for="passwordOld">Old Password</label>
        <input type="password" name="passwordOld" id="passwordOld" />
    </div>
    <div>
        <label for="passwordNew">New Password</label>
        <input type="password" name="passwordNew" id="passwordNew" />
    </div>
    <div>
        <label for="passwordNewConfirm">Confirm New Password</label>
        <input type="password" name="passwordNewConfirm" id="passwordNewConfirm" />
    </div>
    <div>
        <input type="submit" value="Submit" />
        <a href="?action=user&id=<?php echo $model->currentUser->id; ?>">Cancel</a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
