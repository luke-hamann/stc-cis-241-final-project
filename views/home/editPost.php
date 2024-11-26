<?php include('./views/shared/header.php'); ?>

<?php
if ($mode == 'Add') {
    $formAction = '?action=new';
} else if ($mode == 'Edit') {
    $formAction = '?action=editPost&id=' . $post->id;
}
?>

<h1>
    <?php echo $mode; ?> Post
</h1>

<form action="<?php echo $formAction; ?>" method="post">
    <?php include('./views/shared/formErrors.php'); ?>
    <div>
        <label for="forumId">
            Forum
        </label>
        <select name="forumId" id="forumId">
            <option value="0"
                <?php echo (isset($post) && $post->forumId == 0 ? 'selected' : ''); ?>>
                -
            </option>
            <?php foreach ($forums as $forum) : ?>
                <option value="<?php echo $forum->id; ?>"
                    <?php echo (isset($post) && $post->forumId == $forum->id ? 'selected' : ''); ?>>
                    <?php echo htmlspecialchars($forum->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="title">
            Title
        </label>
        <input type="text" name="title" id="title"
            value="<?php echo (isset($post) ? $post->title : ''); ?>" />
    </div>
    <div>
        <label for="content">
            Content
        </label>
        <textarea name="content" id="content" rows="5"><?php
            echo (isset($post) ? $post->title : ''); ?></textarea>
    </div>
    <div>
        <input type="submit" value="Submit" />
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
