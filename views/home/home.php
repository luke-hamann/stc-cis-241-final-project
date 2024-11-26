<?php include('./views/shared/header.php'); ?>

<h1>
    Home
</h1>

<?php if (isset($model->currentUser)) : ?>
    <p>
        <a href="?action=new">
            New Post
        </a>
    </p>
<?php endif; ?>

<?php foreach ($model->posts as $post) : ?>
    <?php include('./views/shared/post.php'); ?>
<?php endforeach; ?>

<?php include('./views/shared/footer.php'); ?>
