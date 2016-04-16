<form method="POST" action="" enctype="multipart/form-data">
    <?= $this->html->errorList() ?>
    <?= $this->html->csrfField() ?>
    <div class="row">
        <label>Profile picture</label>
        <img src="<?= $this->url->generate("/users/{$model->id}/picture") ?>">
    </div>
    <div class="row">
        <label></label>
        <input name="profile_picture" type="file" value="" accept="image/*">
    </div>
    <?= $this->html->textArea('description') ?>
    <?= $this->html->submit('Save') ?>
</form>