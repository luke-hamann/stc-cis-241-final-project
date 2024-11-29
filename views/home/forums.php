<?php include('./views/shared/header.php'); ?>

<div class="container">
    <h1 class="p-3 m-3">Forums</h1>

    <?php if (isset($model->currentUser) && $model->currentUser->isAdmin) : ?>
        <div class="mx-3 px-3">
            <a href="?action=addForum" class="btn btn-primary">&plus; Add Forum</a>
        </div>
    <?php endif; ?>

    <?php if (count($model->forums) == 0) : ?>
        <p class="p-3 m-3">
            No forums.
        </p>
    <?php else : ?>
        <p class="p-3 m-3">
            <?php echo count($model->forums); ?> forum<?php echo (count($model->forums) == 1 ? '' : 's'); ?>
        </p>
        <table class="m-3">
            <tbody>
                <?php foreach ($model->forums as $forum) : ?>
                    <tr>
                        <td>
                            <a href="?action=forum&id=<?php echo $forum->id; ?>" class="d-block m-3 text-decoration-none"><?php echo htmlspecialchars($forum->name); ?></a>
                        </td>
                        <?php if (isset($model->currentUser) && $model->currentUser->isAdmin) : ?>
                            <td>
                                <a href="?action=editForum&id=<?php echo $forum->id; ?>" class="btn btn-warning m-3">Edit</a>
                            </td>
                            <td>
                                <a href="?action=deleteForum&id=<?php echo $forum->id; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
