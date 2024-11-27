<div class="comment-component">
    <p>
        <?php if (!$comment->user->isGhost) : ?>
            <a href="?action=user&id=<?php echo $comment->user->id; ?>"><?php
                echo htmlspecialchars($comment->user->name); ?></a>
        <?php else : ?>
            [deleted user]
        <?php endif; ?>
        (<?php echo $comment->creationDate->format(DATE_RFC7231); ?>)
    </p>
    <p>
        <?php echo nl2br(htmlspecialchars($comment->content)); ?>
    </p>
    <p>
        <?php if (isset($currentUser)) : ?>
            <?php if ($comment->userId == $currentUser->id) : ?>
                <a href="?action=editComment&id=<?php echo $comment->id; ?>"
                    class="btn btn-warning">Edit</a>
            <?php endif; ?>
            <?php if ($comment->userId == $currentUser->id || $currentUser->isAdmin) : ?>
                <a href="?action=deleteComment&id=<?php echo $comment->id; ?>"
                    class="btn btn-danger">Delete</a>
            <?php endif; ?>
        <?php endif; ?>
    </p>
</div>
