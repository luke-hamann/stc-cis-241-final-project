<div>
    <h3>
        <a href="?action=post&id=<?php echo $post->id; ?>">
            <?php echo htmlspecialchars($post->title); ?>
        </a>
    </h3>
    <p>
        <a href="?action=forum&id=<?php echo $post->forumId; ?>">
            <?php echo htmlspecialchars($post->forum->name); ?>
        </a>
    </p>
    <p>
        <?php echo $post->creationDate->format(DATE_RFC7231); ?>
    </p>
    <div>
        <?php echo htmlspecialchars($post->content); ?>
    </div>
</div>
