<?php include('./views/shared/header.php'); ?>

<div class="row my-5">
    <div class="col-md-4 offset-md-4">
        <form action="<?php echo $model->formActionStub . $model->id; ?>" method="post">
            <h1>Confirm Deletion</h1>
            <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
            <div class="mb-3">
                Are you sure you want to delete "<?php
                    echo strlen($model->summary) > 50 ? substr($model->summary, 0, 47) . '...' : $model->summary; ?>"?
            </div>
            <div class="text-center">
                <input type="submit" value="Yes" class="btn btn-danger" />
                <a href="<?php echo $model->cancelUrl; ?>" class="btn btn-secondary">No</a>
            </div>
        </form>
    </div>
</div>

<?php include('./views/shared/footer.php'); ?>
