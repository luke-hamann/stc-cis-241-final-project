<div class="p-3 m-3 border">
    <h2>
        <a href="?action=post&id=<?php echo $post->id; ?>" class="text-decoration-none"><?php echo ($post->isDeleted ? '[deleted]' : htmlspecialchars($post->title)); ?></a>
    </h2>
    <div class="mb-3">
        <a href="?action=forum&id=<?php echo $post->forumId; ?>" class="text-decoration-none"><?php echo htmlspecialchars($post->forum->name); ?></a>
        &bullet;
        <?php if ($post->user->isGhost) : ?>
            [deleted user]
        <?php else : ?>
            <a href="?action=user&id=<?php echo $post->user->id; ?>" class="text-decoration-none"><?php echo htmlspecialchars($post->user->name); ?></a>
        <?php endif; ?>
        &bullet;
        <?php echo $post->creationDate->format(DATE_RFC7231); ?>
        <?php if (isset($currentUser)) : ?>
            <?php if ($post->userId == $currentUser->id || $currentUser->isAdmin) : ?>
                &bullet;
                <form action="?action=deletePost&id=<?php echo $post->id; ?>" method="post" class="d-inline">
                    <input type="submit" value="<?php echo ($post->isDeleted ? 'show' : 'hide'); ?>" class="btn-link bg-transparent border-0 text-primary text-decoration-none" />
                </form>
            <?php endif; ?>
            <?php if ($post->userId == $currentUser->id) : ?>
                &bullet;
                <a href="?action=editPost&id=<?php echo $post->id; ?>" class="text-decoration-none">edit</a>
            <?php endif; ?>
            <?php if ($currentUser->isAdmin) : ?>
                &bullet;
                <a href="?action=deleteThread&id=<?php echo $post->id; ?>" class="text-decoration-none">delete</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div>
        <?php if ($post->isDeleted) : ?>
            [deleted]
        <?php else : ?>
            <?php echo nl2br(htmlspecialchars($post->content)); ?>
        <?php endif; ?>
    </div>
</div>
