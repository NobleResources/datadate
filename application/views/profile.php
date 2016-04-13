<?php /** @var \DataDate\Views\ViewRenderer $this */?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataDate</title>
</head>
<body>
    <form method="POST" action="">
        <?= $this->csrfField() ?>
       
        <?= $this->formSubmit('Save') ?>
    </form>
</body>
</html>