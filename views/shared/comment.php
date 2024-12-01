<div class="p-3 m-3 border">
    <p>
        <?php if ($comment->user->isGhost) : ?>
            [deleted user]
        <?php else : ?>
            <a href="?action=user&id=<?php echo $comment->user->id; ?>" class="text-decoration-none"><?php echo htmlspecialchars($comment->user->name); ?></a>
        <?php endif; ?>
        &bullet;
        <?php echo $comment->creationDate->format(DATE_RFC7231); ?>
        <?php if (isset($currentUser)) : ?>
            <?php if ($comment->userId == $currentUser->id) : ?>
                &bullet;
                <a href="?action=editComment&id=<?php echo $comment->id; ?>" class="text-decoration-none">edit</a>
            <?php endif; ?>
            <?php if ($comment->userId == $currentUser->id || $currentUser->isAdmin) : ?>
                &bullet;
                <a href="?action=deleteComment&id=<?php echo $comment->id; ?>" class="text-decoration-none">delete</a>
            <?php endif; ?>
        <?php endif; ?>
    </p>
    <div>
        <?php echo nl2br(htmlspecialchars($comment->content)); ?>
    </div>
</div>
