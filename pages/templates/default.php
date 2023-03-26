<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Description" />
    <link rel="stylesheet" href="<?= URL ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/style.css">
    <script src="<?= URL ?>/assets/js/send.js" defer type="module"></script>
    <title><?= $app->title ?></title>
</head>

<body>
    <header>
        <?php if ($app->isAdmin()) : ?>
            <a href="<?= URL ?>/account">account</a>
            <a href="<?= URL ?>/admin">admin</a>
        <?php elseif ($app->isUser()) : ?>
            <a href="<?= URL ?>/account">account</a>
        <?php else : ?>
            <a href="<?= URL ?>/login">login</a>
            <a href="<?= URL ?>/register">register</a>
        <?php endif ?>
        <a href="<?= URL ?>/cart">cart</a>
    </header>
    <?= $content ?>
</body>

</html>

<?php

$_SESSION['message'] = "";
