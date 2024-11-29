<?php include('./views/shared/header.php'); ?>

<div class="container">
    <h1 class="m-3 p-3"><?php echo htmlspecialchars($forum->name); ?></h1>
    <?php if (isset($currentUser)) : ?>
        <div class="ms-3 ps-3">
            <a href="?action=new" class="btn btn-primary">&plus; New Post</a>
        </div>
    <?php endif; ?>
    <?php if (count($forum->posts) == 0) : ?>
        <p>No posts.</p>
    <?php else : ?>
        <?php foreach ($forum->posts as $post) : ?>
            <?php include('./views/shared/post.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
