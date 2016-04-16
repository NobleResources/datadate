<form action="" method="POST">
    <?= $this->html->csrfField() ?>
    <?= $this->html->input('email', 'email') ?>
    <?= $this->html->input('password', 'password', false) ?>
    <div class="error"><?= $this->html->firstError('credentials') ?></div>
    <?= $this->html->submit('Sign in') ?>
</form>