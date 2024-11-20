<?php include('./views/shared/header.php'); ?>

<h1>
    Home
</h1>

<?php foreach ($posts as $post) : ?>
    <div>
        <h3>
            <?php echo htmlspecialchars($post->title); ?>
        </h3>
        <p>
            <a href="?action=forum&id=<?php echo $post->forumId; ?>">
                <?php echo htmlspecialchars($post->forum->name); ?>
            </a>
        </p>
        <p>
            
            <?php echo htmlspecialchars($post->creationDate); ?>
        </p>
        <div>
            <?php echo htmlspecialchars($post->content); ?>
        </div>
    </div>
<?php endforeach; ?>

<?php include('./views/shared/footer.php'); ?>
