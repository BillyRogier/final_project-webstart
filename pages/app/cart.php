<main class="grid">
    <section class="cart grid">
        <h1 style="display: none;">Panier</h1>
        <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
        <?php

        use App\Table\Carousel;

        $total = 0;
        if (count($products_in_cart) >= 1) { ?>
            <div class="products_cart-container grid">
                <?php foreach ($products_in_cart as $product) :
                    $product_total = $product['product']->getPrice() *  $product['quantity'];
                    $total += $product_total; ?>
                    <div class="product_cart grid">
                        <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $product['product']->getJoin(Carousel::class)->getImg() ?>" />
                        <div class="head-product grid">
                            <h2><?= $product['product']->getName() ?></h2>
                            <p class="product_price"><?= $product['product']->getPrice() ?> €</p>
                        </div>
                        <div class="quantity-container grid">
                            <?=
                            $form
                                ->change("product_id", ['value' => $product['product']->getId()])
                                ->change("quantity", ['value' => $product['quantity'], 'class' => 'quantity'])
                                ->createView()
                            ?>
                            <div class="total_product-container grid">
                                <p>Total product :</p>
                                <div class="price-container grid">
                                    <p class="total_product"><?= $product_total ?></p>
                                    <p>€</p>
                                </div>
                            </div>
                        </div>
                        <?=
                        $form_del
                            ->change("id", ['value' => $product['product']->getId()])
                            ->createView()
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="checkout-container grid">
                <h3>Récapitulatif de commande</h3>
                <p>nombre d'article : <?= $count_items ?></p>
                <div class="line"></div>
                <div class="total_cart-container grid">
                    <h4>Total</h4>
                    <div class="price-container grid">
                        <p class="total_cart"><?= $total ?></p>
                        <p>€</p>
                    </div>
                </div>
                <a href="<?= URL . (($loged) ? "/valid-user/" . $_SESSION['valid'] : "/login?cart=true") ?>" class="btn">Passer la commande</a>
            </div>
        <?php } else { ?>
            <h2>No products in cart</h2>
        <?php }  ?>
    </section>
    <section class="products-trends grid">
        <div class="header-slider grid">
            <h2>Produits tendances</h2>
            <div class="line"></div>
            <div class="slider-arrows">
                <div class="arrow prev"> <img src="<?= BASE_PUBLIC ?>/assets/icon/arrow_white.svg" alt="arrow left" class="arrow-image left"></div>
                <div class="arrow next"><img src="<?= BASE_PUBLIC ?>/assets/icon/arrow_white.svg" alt="arrow right" class="arrow-image right"></div>
            </div>
        </div>
        <div class="slider-container" id="slider_products-trends">
            <div class="slider">
                <?php foreach ($products_trends as $products_trend) : ?>
                    <a href="<?= URL ?>/product/<?= $products_trend->getId() ?>" class="slider-item product grid">
                        <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $products_trend->getJoin(Carousel::class)->getImg() ?>" />
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