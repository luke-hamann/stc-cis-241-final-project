<div class="post-component">
    <h2>
        <a href="?action=post&id=<?php echo $post->id; ?>">
            <?php echo htmlspecialchars($post->title); ?>
        </a>
    </h2>
    <p>
        Posted to
        <a href="?action=forum&id=<?php echo $post->forumId; ?>"><?php
            echo htmlspecialchars($post->forum->name); ?></a>
        by
        <?php echo htmlspecialchars($post->user->name); ?>
        at
        <?php echo $post->creationDate->format(DATE_RFC7231); ?>
    </p>
    <?php if (isset($currentUser) && $post->userId == $currentUser->id) : ?>
        <p>
            <a href="?action=editPost&id=<?php echo $post->id; ?>">Edit</a>
            <a href="?action=deletePost&id=<?php echo $post->id; ?>">Delete</a>
        </p>
    <?php endif; ?>
    <p>
        <?php echo nl2br(htmlspecialchars($post->content)); ?>
    </p>
</div>
