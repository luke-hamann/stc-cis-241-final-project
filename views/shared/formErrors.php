<?php if (isset($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li>
                <?php echo htmlspecialchars($error); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
