<?php include('./views/shared/header.php'); ?>

<div class="container">
    <h1 class="m-3 p-3">Users</h1>

    <p class="m-3 p-3">
        <?php echo count($model->users); ?> user<?php echo (count($model->users) == 1 ? '' : 's'); ?>
    </p>

    <table class="m-3 p-3">
        <tbody>
            <?php foreach($model->users as $user) : ?>
                <tr>
                    <td class="p-3">
                        <a href="?action=user&id=<?php echo $user->id; ?>" class="text-decoration-none"><?php echo htmlspecialchars($user->name); ?></a>
                    </td>
                    <?php if (isset($model->currentUser) && $model->currentUser->isAdmin) : ?>
                        <td class="p-3">
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
                        <td class="p-3">
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
</div>

<?php include('./views/shared/footer.php'); ?>
