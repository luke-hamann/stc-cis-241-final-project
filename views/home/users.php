<?php include('./views/shared/header.php'); ?>

<h1>Users</h1>

<table class="table table-striped">
    <tbody>
        <?php foreach($model->users as $user) : ?>
            <tr>
                <td>
                    <a href="?action=user&id=<?php echo $user->id; ?>">
                        <?php echo htmlspecialchars($user->name); ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('./views/shared/footer.php'); ?>
