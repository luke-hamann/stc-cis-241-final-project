<div class="post-component p-2">
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
        on
        <?php echo $post->creationDate->format(DATE_RFC7231); ?>
    </p>
    <?php if (isset($currentUser)) : ?>
        <div>
            <?php if ($post->userId == $currentUser->id) : ?>
                <a href="?action=editPost&id=<?php echo $post->id; ?>"
                    class="btn btn-warning">Edit</a>
                <a href="?action=deletePost&id=<?php echo $post->id; ?>"
                    class="btn btn-danger">Mark as deleted</a>
            <?php endif; ?>
            <?php if ($currentUser->admin) : ?>
                <a href="?action=deleteThread&id=<?php echo $post->id; ?>"
                    class="btn btn-danger">Delete thread</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <p>
        <?php echo nl2br(htmlspecialchars($post->content)); ?>
    </p>
</div>
