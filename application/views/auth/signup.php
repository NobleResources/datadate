<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataDate</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <form action="/signup" method="POST">
        <?= csrf_field() ?>
        <?= form_field('email', 'email', $this->getOld('email'), $this->getFirstError('email')) ?>
        <?= form_field('password', 'password', '', $this->getFirstError('password')) ?>
        <?= form_field('password_confirmation', 'password') ?>
        <div class="form-field"><button type="submit">Sign up!</button></div>
    </form>
</body>
</html>

