<div class="comment-component">
    <p>
        <a href="?action=user&id=<?php echo $comment->user->id; ?>"><?php
            echo htmlspecialchars($comment->user->name); ?></a>
    <p>
    <p>
        <?php echo $comment->creationDate->format(DATE_RFC7231); ?>
    </p>
    <?php if (isset($currentUser) && $comment->userId == $currentUser->id) : ?>
        <p>
            <a href="?action=editComment&id=<?php
                echo $comment->id; ?>">Edit</a>
            <a href="?action=deleteComment&id=<?php
                echo $comment->id; ?>">Delete</a>
        </p>
    <?php endif; ?>
    <p>
        <?php echo nl2br(htmlspecialchars($comment->content)); ?>
    </p>
</div>
