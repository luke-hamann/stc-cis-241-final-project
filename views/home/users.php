<?php include('./views/shared/header.php'); ?>

<div class="row">
    <h1 class="p-3 mt-3 mb-0">Users</h1>
    <p class="p-3">
        <?php echo count($model->users) . ' user' .  (count($model->users) == 1 ? '' : 's'); ?>
    </p>
    <table class="table table-striped p-3 mb-5">
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
                                <div class="d-inline-block">
                                    <input type="checkbox" name="confirm" id="confirm-reset-<?php echo $user->id; ?>" />
                                    <label for="confirm-reset-<?php echo $user->id; ?>">
                                        Confirm
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="p-3">
                            <?php if (!$user->isAdmin) : ?>
                                <a href="?action=deleteUser&id=<?php echo $user->id; ?>" class="btn btn-danger">
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
