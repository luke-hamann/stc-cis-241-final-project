<?php include('./views/shared/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($forum->name); ?>
</h1>

<?php if (isset($currentUser)) : ?>
    <p>
        <a href="?action=new">
            New Post
        </a>
    </p>
<?php endif; ?>

<?php if (count($forum->posts) == 0) : ?>
    <p>
        No posts.
    </p>
<?php else : ?>
    <?php foreach ($forum->posts as $post) : ?>
        <?php include('./views/shared/post.php'); ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php include('./views/shared/footer.php'); ?>
