<?php include('./views/shared/header.php'); ?>

<h1>Users</h1>

<p>
    <?php echo count($model->users); ?> user<?php echo (count($model->users) == 1 ? '' : 's'); ?>
</p>

<table class="table table-striped">
    <tbody>
        <?php foreach($model->users as $user) : ?>
            <tr>
                <td>
                    <a href="?action=user&id=<?php echo $user->id; ?>">
                        <?php echo htmlspecialchars($user->name); ?>
                    </a>
                </td>
                <?php if (isset($model->currentUser) && $model->currentUser->isAdmin) : ?>
                    <td>
                        <form action="?action=resetPassword" method="post">
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
                            <input type="submit" value="Reset Password" class="btn btn-warning" />
                            <input type="checkbox" name="confirm"
                                id="confirm-reset-<?php echo $user->id; ?>"/>
                            <label for="confirm-reset-<?php echo $user->id; ?>">
                                Confirm
                            </label>
                        </form>
                    </td>
                    <td>
                        <?php if (!$user->isAdmin) : ?>
                            <a href="?action=deleteUser&id=<?php echo $user->id; ?>"
                                class="btn btn-danger">
                                Delete
                            </a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('./views/shared/footer.php'); ?>
