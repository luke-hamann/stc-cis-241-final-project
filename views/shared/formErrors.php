<?php if (count($model->getErrors()) > 0) : ?>
    <ul class="text-danger">
        <?php foreach ($model->getErrors() as $error) : ?>
            <li>
                <?php echo htmlspecialchars($error); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
