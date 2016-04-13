<?php
/**
 * @var \DataDate\Views\ViewRenderer $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataDate</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<form action="" method="POST">
    <?= $this->csrfField() ?>
    <?= $this->formInput('email', 'email') ?>
    <?= $this->formInput('password', 'password', false) ?>
    <div class="error"><?= $this->getFirstError('credentials') ?></div>
    <?= $this->formSubmit('Sign in') ?>
</form>
</body>
</html>

