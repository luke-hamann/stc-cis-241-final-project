<?php include('./views/shared/header.php'); ?>

<h1>
    Confirm Deletion
</h1>

<?php
if (is_a($object, 'Post')) {
    $formAction = '?action=deletePost&id=' . $object->id;
    $summary = $object->title;
    $cancelUrl = '?action=post&id=' . $object->id;
} else if (is_a($object, 'Comment')) {
    $formAction = '?action=deleteComment&id=' . $object->id;
    $summary = htmlspecialchars(substr($object->content, 0, 20));
    $cancelUrl = '?action=post&id=' . $object->postId;
}
?>

<form action="<?php echo $formAction; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $object->id; ?>" />
    <div>
        Are you sure you want to delete "<?php echo $summary; ?>"?
    </div>
    <div>
        <input type="submit" value="Yes" />
        <a href="<?php echo $cancelUrl; ?>">
            No
        </a>
    </div>
</form>

<?php include('./views/shared/footer.php'); ?>
