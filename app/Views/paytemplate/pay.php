<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('paytemplate/metacss') ?>
</head>

<body>
    <?= $this->renderSection('content'); ?>
    <?= $this->include('paytemplate/script') ?>
</body>

</html>