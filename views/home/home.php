<?php include('./views/shared/header.php'); ?>

<div class="row">
    <h1 class="p-3 mt-3 mb-0">Recent Posts</h1>
    <?php if (isset($model->currentUser)) : ?>
        <div class="p-3">
            <a href="?action=new" class="btn btn-primary">&plus; New Post</a>
        </div>
    <?php endif; ?>
    <?php foreach ($model->posts as $post) : ?>
        <?php include('./views/shared/post.php'); ?>
    <?php endforeach; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
