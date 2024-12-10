<?php include('./views/shared/header.php'); ?>

<?php
if ($model->mode == 'Add') {
    $formAction = '?action=new';
} else if ($model->mode == 'Edit') {
    $formAction = '?action=editPost&id=' . $model->post->id;
}
?>

<div class="row my-5">
    <div class="col-md-6 offset-md-3">
        <form action="<?php echo $formAction; ?>" method="post">
            <h1><?php echo $model->mode; ?> Post</h1>
            <?php include('./views/shared/formErrors.php'); ?>
            <div class="mb-3">
                <label for="forumId" class="form-label">Forum</label>
                <select name="forumId" id="forumId" class="form-select">
                    <option value="0" <?php echo (isset($model->post) && $model->post->forumId == 0 ? 'selected' : ''); ?>>-</option>
                    <?php foreach ($model->forums as $forum) : ?>
                        <option value="<?php echo $forum->id; ?>" <?php echo (isset($model->post) && $model->post->forumId == $forum->id ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($forum->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" value="<?php echo (isset($model->post) ? $model->post->title : ''); ?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" rows="5" class="form-control"><?php echo (isset($model->post) ? $model->post->content : ''); ?></textarea>
            </div>
            <div class="text-center">
                <input type="submit" value="Submit" class="btn btn-primary" />
                <a href="<?php echo ($model->mode == 'Add' ? '?action=home' : '?action=post&id=' . $model->post->id ); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
