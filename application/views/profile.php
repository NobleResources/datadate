<form method="POST" action="">
    <?= $this->csrfField() ?>
    <?= $this->textArea('description') ?>
    <?= $this->formSubmit('Save') ?>
</form>