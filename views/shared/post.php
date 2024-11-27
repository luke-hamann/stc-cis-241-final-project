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
        <?php if (!$post->user->isGhost) : ?>
            <a href="?action=user&id=<?php echo $post->user->id; ?>"><?php
                echo htmlspecialchars($post->user->name); ?></a>
        <?php else : ?>
            [deleted user]
        <?php endif; ?>
        on
        <?php echo $post->creationDate->format(DATE_RFC7231); ?>
    </p>
    <?php if (isset($currentUser)) : ?>
        <div>
            <?php if ($post->userId == $currentUser->id) : ?>
                <a href="?action=editPost&id=<?php echo $post->id; ?>"
                    class="btn btn-warning">Edit</a>
            <?php endif; ?>
            <?php if ($post->userId == $currentUser->id || $currentUser->isAdmin) : ?>
                <a href="?action=deletePost&id=<?php echo $post->id; ?>"
                    class="btn btn-danger">Mark as deleted</a>
            <?php endif; ?>
            <?php if ($currentUser->isAdmin) : ?>
                <a href="?action=deleteThread&id=<?php echo $post->id; ?>"
                    class="btn btn-danger">Delete thread</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <p>
        <?php echo nl2br(htmlspecialchars($post->content)); ?>
    </p>
</div>
