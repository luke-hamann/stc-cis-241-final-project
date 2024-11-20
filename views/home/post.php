<?php include('./views/shared/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($post->title); ?>
</h1>
<p>
    Posted to
    <a href="?action=forum&id=<?php echo $post->forumId; ?>">
        <?php echo htmlspecialchars($post->forum->name); ?>
    </a>
    by
    <?php echo htmlspecialchars($post->user->name); ?>
    at
    <?php echo $post->creationDate->format(DATE_RFC7231); ?>
</p>
<p>
    <?php echo nl2br(htmlspecialchars($post->content)); ?>
</p>

<h2>Comments</h2>

<?php if (isset($currentUser)) : ?>
    <form action="?action=post" method="post">
        <input type="hidden" name="postId" value="<?php echo $post->id; ?>" />
        <div>
            <textarea name="content"><?php
                echo (isset($comment) ? $comment->content : ''); ?></textarea>
        </div>
        <div>
            <input type="submit" value="Comment" />
        </div>
    </form>
<?php endif; ?>

<p>
    <?php echo count($post->comments) . ' comment' .
        (count($post->comments) == 1 ? '' : 's'); ?>
</p>

<?php if (count($post->comments) > 0) : ?>
    <?php foreach ($post->comments as $comment) : ?>
        <div>
            <p>
                <?php echo htmlspecialchars($comment->user->name); ?> 
            <p>
            <p>
                <?php echo $comment->creationDate->format(DATE_RFC7231); ?>
            </p>
            <?php if (isset($currentUser) && $comment->userId == $currentUser->id) : ?>
                <p>
                    <a href="?action=editComment&id=<?php echo $comment->id; ?>">Edit</a>
                    <a href="?action=deleteComment&id=<?php echo $comment->id; ?>">Delete</a>
                </p>
            <?php endif; ?>
            <p>
                <?php echo nl2br(htmlspecialchars($comment->content)); ?>
            </p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include('./views/shared/footer.php'); ?>
