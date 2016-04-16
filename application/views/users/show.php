<div class="overview">
    <div class="row"><h1><?= $model->nickname ?></h1></div>
    <div class="row"><img src="<?= $this->url->generate("/users/{$model->id}/picture") ?>"></div>
    <?= $this->html->display('email') ?>
    <?= $this->html->display('first_name')?>
    <?= $this->html->display('last_name')?>
    <?= $this->html->display('gender') ?>
    <?= $this->html->display('birthday')?>
    <?= $this->html->display('description') ?>
</div>