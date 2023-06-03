<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Description" />
    <link rel="stylesheet" href="<?= URL ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/style.css">
    <script src="<?= URL ?>/assets/js/main.js" defer type="module"></script>
    <title><?= $app->title ?></title>
</head>

<body>
    <header class="grid">
        <a href="<?= URL ?>" class="logo grid"><img src="<?= URL ?>/assets/icon/logo.svg" alt="logo"><img src="<?= URL ?>/assets/icon/logo_name.svg" alt="Espreso Tools" class="logo_name"></a>
        <nav class="grid">
            <div class="links grid">
                <div class="icon search"><img src="<?= URL ?>/assets/icon/search.svg" alt="search"></div>
                <a href="<?= URL . ($app->isUser() || $app->isAdmin() ? "/account" : "/login") ?>" class="icon"><img src="<?= URL ?>/assets/icon/login.svg" alt="login"></a>
                <a href="<?= URL ?>/cart" class="icon cart">
                    <span class="number_in_cart grid">
                        <?php

                        use App\Table\Categorys;

                        $totalCount = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $quantity) {
                                $totalCount += $quantity;
                            }
                        }

                        echo ($totalCount > 99 ? "99+" : $totalCount)  ?>
                    </span>
                    <img src="<?= URL ?>/assets/icon/cart.svg" alt="cart">
                </a>
            </div>
            <div class="menu_burger grid">
                <div class="menu_burger-logo grid">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <p>Menu</p>
            </div>
        </nav>
        <div class="menu grid">
            <div class="close-menu grid">
                <img src="<?= URL ?>/assets/icon/close.svg" alt="close menu" class="icon">
            </div>
            <div class="menu-links grid">
                <li>
                    <div class="products_dropdown grid">
                        <div href="#" class="big_link">Products</div>
                        <img src="<?= URL ?>/assets/icon/arrow.svg" alt="arrow">
                    </div>
                    <ul class="products_links grid">
                        <div class="menu_part grid">
                            <p>Produits</p>
                        </div>
                        <li><a href="#" class="link">Tous les produits</a></li>
                        <?php

                        $CategorysTable = new Categorys();
                        $categorys = $CategorysTable->findAll();

                        foreach ($categorys as $category) : ?>
                            <li><a href="#" class="link"><?= $category->getCategory_name() ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="#" class="big_link">À propos</a></li>
                <li><a href="#" class="big_link">Contact</a></li>
            </div>
        </div>
    </header>
    <?= $content ?>
</body>

</html>