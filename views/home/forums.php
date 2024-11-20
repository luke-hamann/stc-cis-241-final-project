<?php include('./views/shared/header.php'); ?>

<h1>Forums</h1>

<?php if (count($forums) == 0) : ?>
    <p>
        No forums.
    </p>
<?php else : ?>
    <ul>
        <?php foreach ($forums as $forum) : ?>
            <li>
                <a href="?action=forum&id=<?php echo $forum->id; ?>">
                    <?php echo htmlspecialchars($forum->name); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include('./views/shared/footer.php'); ?>