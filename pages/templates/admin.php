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
        <a href="<?= URL ?>/admin">Admin</a>
        <div>
            <a href="<?= URL ?>/admin/users">Users</a>
            <a href="<?= URL ?>/admin/users/insert">Insert user</a>
        </div>
        <div>
            <a href="<?= URL ?>/admin/categorys">Categorys</a>
            <a href="<?= URL ?>/admin/categorys/insert">Insert category</a>
        </div>
        <div>
            <a href="<?= URL ?>/admin/products">Products</a>
            <a href="<?= URL ?>/admin/products/insert">Insert product</a>
        </div>
        <div>
            <a href="<?= URL ?>/admin/orders">Orders</a>
            <a href="<?= URL ?>/admin/orders/insert">Insert order</a>
        </div>
        <a href="<?= URL ?>/logout">Logout</a>
    </header>

    <?= $content ?>
</body>

</html>