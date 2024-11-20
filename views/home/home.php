<?php include('./views/shared/header.php'); ?>

<h1>
    Home
</h1>

<?php if (isset($currentUser)) : ?>
    <p>
        <a href="?action=new">
            New Post
        </a>
    </p>
<?php endif; ?>

<?php foreach ($posts as $post) : ?>
    <?php include('./views/shared/post.php'); ?>
<?php endforeach; ?>

<?php include('./views/shared/footer.php'); ?>
