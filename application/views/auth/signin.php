<form action="" method="POST">
    <?= $this->csrfField() ?>
    <?= $this->formInput('email', 'email') ?>
    <?= $this->formInput('password', 'password', false) ?>
    <div class="error"><?= $this->getFirstError('credentials') ?></div>
    <?= $this->formSubmit('Sign in') ?>
</form>