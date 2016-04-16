<form id="signup-form" action="" method="POST">
    <?= $this->html->csrfField() ?>
    <?= $this->html->errorList() ?>
    <?= $this->html->input('email', 'email') ?>
    <?= $this->html->input('nickname', 'text')?>
    <?= $this->html->input('password', 'password', false) ?>
    <?= $this->html->input('password_confirmation', 'password', false) ?>
    <?= $this->html->input('first_name', 'text')?>
    <?= $this->html->input('last_name', 'text')?>
    <?= $this->html->select('gender', ['male' => 'Male', 'female' => 'Female']) ?>
    <?= $this->html->input('birthday', 'date')?>
    <?= $this->html->submit('Sign up') ?>
</form>