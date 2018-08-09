
<?php if (isset($_SESSION['errors'])): ?>
    <div class="error_display">
        <ul>
            <?php foreach($_SESSION['errors'] as $error): ?>
                <li> <?= $error ?> </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['info'])): ?>
    <div class="error_display">
        <ul>
            <?php foreach($_SESSION['info'] as $info): ?>
                <li> <?= $info ?> </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['info']); ?>
<?php endif; ?>


