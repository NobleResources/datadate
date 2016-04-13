<?php /** @var \DataDate\Views\ViewRenderer $this */?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataDate</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<header>
    <h1>DataDate</h1>
</header>
<div class="content">
    <form id="signup-form" action="" method="POST">
        <?= $this->csrfField() ?>
        <?= $this->errorList() ?>
        <?= $this->formInput('email', 'email') ?>
        <?= $this->formInput('nickname', 'text')?>
        <?= $this->formInput('password', 'password', false) ?>
        <?= $this->formInput('password_confirmation', 'password', false) ?>
        <?= $this->formInput('first_name', 'text')?>
        <?= $this->formInput('last_name', 'text')?>
        <?= $this->formSelect('gender', ['male' => 'Male', 'female' => 'Female']) ?>
        <?= $this->formInput('birthday', 'date')?>
        <?= $this->formSubmit('Sign up') ?>
    </form>
</div>
</body>
</html>

