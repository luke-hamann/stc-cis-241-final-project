<?php include('./views/shared/header.php'); ?>

<h1>Forums</h1>

<?php if (isset($model->currentUser) && $model->currentUser->admin) : ?>
    <a href="?action=addForum" class="btn btn-primary">Add Forum</a>
<?php endif; ?>

<?php if (count($model->forums) == 0) : ?>
    <p>
        No forums.
    </p>
<?php else : ?>
    <table>
        <tbody>
            <?php foreach ($model->forums as $forum) : ?>
                <tr>
                    <td>
                        <a href="?action=forum&id=<?php echo $forum->id; ?>">
                            <?php echo htmlspecialchars($forum->name); ?>
                        </a>
                    </td>
                    <?php if (isset($model->currentUser) && $model->currentUser->admin) : ?>
                        <td>
                            <a href="?action=editForum&id=<?php echo $forum->id; ?>">Edit</a>
                        </td>
                        <td>
                            <a href="?action=deleteForum&id=<?php echo $forum->id; ?>">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include('./views/shared/footer.php'); ?>