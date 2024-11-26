<?php if (isset($model->errors) && count($model->errors) > 0) : ?>
    <ul>
        <?php foreach ($model->errors as $error) : ?>
            <li>
                <?php echo htmlspecialchars($error); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
