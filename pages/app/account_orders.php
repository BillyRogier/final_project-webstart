<main class="grid">
    <h1 style="display: none;">Account</h1>
    <section class="account_order grid">
        <ul class="account_links grid">
            <h3>Menu</h3>
            <div class="line"></div>
            <?php if ($app->isAdmin()) : ?>
                <li><a href="<?= URL ?>/admin">Admin</a></li>
                <div class="line"></div>
            <?php endif ?>
            <li><a href="<?= URL ?>/account">Commandes</a></li>
            <div class="line"></div>
            <li><a href="<?= URL ?>/account/settings">Paramètres</a></li>
        </ul>
        <div class="orders-container grid">
            <?php

            use App\Table\Carousel;
            use App\Table\Products;


            $total = 0;
            for ($i = 0; $i < count($orders); $i++) :
                if (isset($orders[$i + 1]) && ($orders[$i]->getOrder_num() == $orders[$i + 1]->getOrder_num())) {
                    $total += $orders[$i]->getQuantity() * $orders[$i]->getJoin(Products::class)->getPrice(); ?>
                    <div class="order grid">
                        <div class="order-product-container grid">
                            <a href="<?= URL ?>/product/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="order-product grid">
                                <img src="<?= URL ?>/assets/img/<?= $orders[$i]->getJoin(Carousel::class)->getImg() ?>" />
                                <p><?= $orders[$i]->getQuantity() ?> x <?= $orders[$i]->getJoin(Products::class)->getName() ?></p>
                                <p><?= $orders[$i]->getQuantity() * $orders[$i]->getJoin(Products::class)->getPrice() ?> €</p>
                            </a>
                            <a href="<?= URL ?>/add-comment/<?= $orders[$i]->getOrder_num() ?>/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="btn">Ajouter un commentaire</a>
                            <div class="line"></div>
                        </div>
                    <?php } else if (isset($orders[$i - 1]) && ($orders[$i]->getOrder_num() == $orders[$i - 1]->getOrder_num())) {
                    $total += $orders[$i]->getQuantity() * $orders[$i]->getJoin(Products::class)->getPrice(); ?>
                        <div class="order-product-container grid">
                            <a href="<?= URL ?>/product/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="order-product grid">
                                <img src="<?= URL ?>/assets/img/<?= $orders[$i]->getJoin(Carousel::class)->getImg() ?>" />
                                <p><?= $orders[$i]->getQuantity() ?> x <?= $orders[$i]->getJoin(Products::class)->getName() ?></p>
                                <p><?= $orders[$i]->getQuantity() * $orders[$i]->getJoin(Products::class)->getPrice() ?> €</p>
                            </a>
                            <a href="<?= URL ?>/add-comment/<?= $orders[$i]->getOrder_num() ?>/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="btn">Ajouter un commentaire</a>
                        </div>
                        <div class="order-head grid">
                            <div class="order-head-date">
                                <p>Commende éffectué le</p>
                                <p><?= $orders[$i]->getOrder_date() ?></p>
                            </div>
                            <div class="order-head-date">
                                <p>Total</p>
                                <p><?= $total ?> €</p>
                            </div>
                            <div class="line"></div>
                        </div>
                    </div>
                <?php $total = 0;
                } else {
                    $total = $orders[$i]->getQuantity() * $orders[$i]->getJoin(Products::class)->getPrice(); ?>
                    <div class="order grid">
                        <div class="order-product-container grid">
                            <a href="<?= URL ?>/product/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="order-product grid">
                                <img src="<?= URL ?>/assets/img/<?= $orders[$i]->getJoin(Carousel::class)->getImg() ?>" />
                                <p><?= $orders[$i]->getQuantity() ?> x <?= $orders[$i]->getJoin(Products::class)->getName() ?></p>
                                <p><?= $orders[$i]->getQuantity() * $orders[$i]->getJoin(Products::class)->getPrice() ?> €</p>
                            </a>
                            <a href="<?= URL ?>/add-comment/<?= $orders[$i]->getOrder_num() ?>/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="btn">Ajouter un commentaire</a>
                        </div>
                        <div class="order-head grid">
                            <div class="order-head-date">
                                <p>Commende éffectué le</p>
                                <p><?= $orders[$i]->getOrder_date() ?></p>
                            </div>
                            <div class="order-head-date">
                                <p>Total</p>
                                <p><?= $total ?> €</p>
                            </div>
                            <div class="line"></div>
                        </div>
                    </div>
                <?php $total = 0;
                } ?>
            <?php endfor ?>
    </section>
    <section class="products-trends grid">
        <div class="header-slider grid">
            <h2>Produits tendances</h2>
            <div class="line"></div>
            <div class="slider-arrows">
                <div class="arrow prev"> <img src="<?= URL ?>/assets/icon/arrow_white.svg" alt="arrow left" class="arrow-image left"></div>
                <div class="arrow next"><img src="<?= URL ?>/assets/icon/arrow_white.svg" alt="arrow right" class="arrow-image right"></div>
            </div>
        </div>
        <div class="slider-container" id="slider_products-trends">
            <div class="slider">
                <?php foreach ($products_trends as $products_trend) : ?>
                    <a href="<?= URL ?>/product/<?= $products_trend->getId() ?>" class="slider-item product grid">
                        <img src="<?= URL ?>/assets/img/<?= $products_trend->getJoin(Carousel::class)->getImg() ?>" />
                        <div class="product-data grid">
                            <h3><?= $products_trend->getName() ?></h3>
                            <p><?= $products_trend->getPrice() ?> €</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>