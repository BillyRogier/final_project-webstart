<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Description" />
    <link rel="stylesheet" href="<?= BASE_PUBLIC ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= BASE_PUBLIC ?>/assets/css/style.css">
    <script src="<?= BASE_PUBLIC ?>/assets/js/main.js" defer type="module"></script>
    <title><?= $app->title ?></title>
</head>

<body>
    <header class="grid">
        <a href="<?= URL ?>" class="logo grid"><img src="<?= BASE_PUBLIC ?>/assets/icon/logo.svg" alt="logo"><img src="<?= BASE_PUBLIC ?>/assets/icon/logo_name.svg" alt="Espreso Tools" class="logo_name"></a>
        <nav class="grid">
            <div class="links grid">
                <a href="<?= URL . ($app->isUser() || $app->isAdmin() ? "/account" : "/login") ?>" class="icon"><img src="<?= BASE_PUBLIC ?>/assets/icon/login.svg" alt="login"></a>
                <a href="<?= URL ?>/cart" class="icon icon_cart">
                    <span class="number_in_cart grid">
                        <?php


                        $totalCount = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $quantity) {
                                $totalCount += $quantity;
                            }
                        }

                        echo ($totalCount > 99 ? "99+" : $totalCount)  ?>
                    </span>
                    <img src="<?= BASE_PUBLIC ?>/assets/icon/cart.svg" alt="cart">
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
                <img src="<?= BASE_PUBLIC ?>/assets/icon/close.svg" alt="close menu" class="icon">
            </div>
            <div class="menu-links grid">
                <li>
                    <div class="products_dropdown grid">
                        <div href="#" class="big_link">Produits</div>
                        <img src="<?= BASE_PUBLIC ?>/assets/icon/arrow.svg" alt="arrow">
                    </div>
                    <ul class="products_links grid">
                        <div class="menu_part grid">
                            <p>Produits</p>
                        </div>
                        <li><a href="<?= URL  ?>/category/all-products" class="link">Tous les produits</a></li>
                        <?php

                        use App\Table\Categorys;
                        use App\Table\Settings;

                        $CategorysTable = new Categorys();
                        $categorys = $CategorysTable->findAll();

                        foreach ($categorys as $category) : ?>
                            <li><a href="<?= URL ?>/category/<?= $category->getUrl() ?>" class="link"><?= ucfirst($category->getCategory_name()) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="<?= URL  ?>/about" class="big_link">À propos</a></li>
                <li><a href="<?= URL  ?>/contact" class="big_link">Contact</a></li>
            </div>
        </div>
    </header>
    <?= $content ?>
    <footer class="grid">
        <div class="footer-container grid">
            <p class="footer-title">Newsletter</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <form action="" method="post" class="grid">
                <input type="email" name="email_newsletter" placeholder="email">
                <button class="btn">S'inscrire</button>
            </form>
        </div>
        <div class="footer-container grid">
            <p class="footer-title">Aide & Services</p>
            <div class="info-container grid">
                <p>Statut de commande</p>
                <p>Expédition et livraison</p>
                <p>Retours</p>
                <p>Modes de paiement</p>
                <p>Nous contacter</p>
            </div>
        </div>
        <div class="footer-container grid">
            <p class="footer-title">Informations légales</p>
            <div class="info-container grid">
                <a href="<?= URL ?>/mentions-legales" class="foot-link">Mentions légales</a>
                <a href="<?= URL ?>/sell-condition" class="foot-link">Conditions générales de vente</a>
            </div>
        </div>
        <div class="footer-bottom grid">
            <p>© Espresso Tools. Tous droits réservés.</p>
            <?php

            $SettingsTable = new Settings();
            $settings = $SettingsTable->findOne();

            if ($settings->getFacebook() || $settings->getInstagram()) : ?>
                <div class="social_media-container grid">
                    <?php if ($settings->getInstagram()) : ?>
                        <a href="<?= $settings->getInstagram() ?>" class="foot-link icon"><img src="<?= BASE_PUBLIC ?>/assets/icon/instagram.svg" alt="instagram"></a>
                    <?php endif;
                    if ($settings->getFacebook()) : ?>
                        <a href="<?= $settings->getFacebook() ?>" class="foot-link icon"><img src="<?= BASE_PUBLIC ?>/assets/icon/facebook.svg" alt="facebook"></a>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    </footer>
</body>

</html>