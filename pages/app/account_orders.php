<main class="grid">
    <h1 style="display: none;">Account</h1>
    <section class="account_order grid">
        <div class="orders-container grid">
            <?php

            use App\Table\Carousel;
            use App\Table\Products;

            for ($i = 0; $i < count($orders); $i++) : ?>
                <?php if (isset($orders[$i + 1]) && ($orders[$i]->getOrder_num() == $orders[$i + 1]->getOrder_num())) { ?>
                    <div class="order grid">
                        <div class="order-product-container grid">
                            <a href="<?= URL ?>/product/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="order-product grid">
                                <img src="<?= URL ?>/assets/img/<?= $orders[$i]->getJoin(Carousel::class)->getImg() ?>" />
                                <h3><?= $orders[$i]->getJoin(Products::class)->getName() ?></h3>
                                <p><?= $orders[$i]->getJoin(Products::class)->getPrice() ?> €</p>
                            </a>
                            <p><?= $orders[$i]->getQuantity() ?></p>
                            <a href="<?= URL ?>/add-comment/<?= $orders[$i]->getOrder_num() ?>/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="btn">Ajouter un commentaire</a>
                        </div>
                    <?php } else if (isset($orders[$i - 1]) && ($orders[$i]->getOrder_num() == $orders[$i - 1]->getOrder_num())) { ?>
                        <div class="order-product-container grid">
                            <a href="<?= URL ?>/product/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="order-product grid">
                                <img src="<?= URL ?>/assets/img/<?= $orders[$i]->getJoin(Carousel::class)->getImg() ?>" />
                                <h3><?= $orders[$i]->getJoin(Products::class)->getName() ?></h3>
                                <p><?= $orders[$i]->getJoin(Products::class)->getPrice() ?> €</p>
                            </a>
                            <p><?= $orders[$i]->getQuantity() ?></p>
                            <a href="<?= URL ?>/add-comment/<?= $orders[$i]->getOrder_num() ?>/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="btn">Ajouter un commentaire</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="order grid">
                        <div class="order-product-container grid">
                            <a href="<?= URL ?>/product/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="order-product grid">
                                <img src="<?= URL ?>/assets/img/<?= $orders[$i]->getJoin(Carousel::class)->getImg() ?>" />
                                <h3><?= $orders[$i]->getJoin(Products::class)->getName() ?></h3>
                                <p><?= $orders[$i]->getJoin(Products::class)->getPrice() ?> €</p>
                            </a>
                            <p><?= $orders[$i]->getQuantity() ?></p>
                            <a href="<?= URL ?>/add-comment/<?= $orders[$i]->getOrder_num() ?>/<?= $orders[$i]->getJoin(Products::class)->getId() ?>" class="btn">Ajouter un commentaire</a>
                        </div>
                    </div>
                <?php } ?>
            <?php endfor ?>
    </section>
</main>