<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Description" />
    <link rel="stylesheet" href="<?= URL ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/admin.css">
    <script src="<?= URL ?>/assets/js/main.js" defer type="module"></script>
    <title><?= $app->title ?></title>
</head>

<body>
    <header>
        <a href="<?= URL ?>/admin/users">Users</a>
        <a href="<?= URL ?>/admin/insert-user">Insert user</a>
    </header>

    <?= $content ?>
</body>

</html>

<?php

$_SESSION['message'] = "";
