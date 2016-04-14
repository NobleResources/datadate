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