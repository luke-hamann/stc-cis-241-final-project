<?php include('./views/shared/header.php'); ?>

<div class="container">
    <div class="p-3 m-3">
        <h1>Recent Posts</h1>
        <?php if (isset($model->currentUser)) : ?>
            <p>
                <a href="?action=new" class="btn btn-primary">&plus; New Post</a>
            </p>
        <?php endif; ?>
    </div>
    <?php foreach ($model->posts as $post) : ?>
        <?php include('./views/shared/post.php'); ?>
    <?php endforeach; ?>
</div>

<?php include('./views/shared/footer.php'); ?>