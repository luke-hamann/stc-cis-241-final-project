<?php include('./views/shared/header.php'); ?>

<div class="row">
    <h1 class="p-3 mt-3 mb-0"><?php echo htmlspecialchars($forum->name); ?></h1>
    <?php if (isset($currentUser)) : ?>
        <div class="p-3">
            <a href="?action=new" class="btn btn-primary">&plus; New Post</a>
        </div>
    <?php endif; ?>
    <?php if (count($forum->posts) == 0) : ?>
        <div class="p-3">No posts.</div>
    <?php else : ?>
        <?php foreach ($forum->posts as $post) : ?>
            <?php include('./views/shared/post.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include('./views/shared/footer.php'); ?>
