<?php if (!$model->isValid()) : ?>
    <ul class="text-danger my-3">
        <?php foreach ($model->getErrors() as $error) : ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
