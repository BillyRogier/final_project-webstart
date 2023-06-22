<main class="grid">
    <h1 style="display: none;">Validation de la commande</h1>
    <section class="cart grid">
        <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
        <div class="products_cart-container grid">
            <?php

            use App\Table\Carousel;

            $total = 0;

            foreach ($products_in_cart as $product) :
                $product_total = $product['product']->getPrice() *  $product['quantity'];
                $total += $product_total; ?>
                <div class="product_cart grid">
                    <img src="<?= BASE_PUBLIC ?>/assets/img/<?= $product['product']->getJoin(Carousel::class)->getImg() ?>" />
                    <div class="head-product grid">
                        <h2><?= $product['quantity'] . " x " . $product['product']->getName() ?></h2>
                        <p class="product_price"><?= $product['product']->getPrice() ?> €</p>
                    </div>
                    <div class="quantity-container grid">
                        <div class="total_product-container grid">
                            <p>Total product :</p>
                            <div class="price-container grid">
                                <p class="total_product"><?= $product_total ?></p>
                                <p>€</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="checkout-container grid">
            <h3>Récapitulatif de commande</h3>
            <p>nombre d'article : <?= $count_items ?></p>
            <div class="line"></div>
            <p>Livré à : <?= $user->getFirst_name() . " " . $user->getLast_name() ?></p>
            <p>Au : <?= $user->getAdress() ?></p>
            <div class="line"></div>
            <div class="total_cart-container grid">
                <h4>Total</h4>
                <div class="price-container grid">
                    <p class="total_cart"><?= $total ?></p>
                    <p>€</p>
                </div>
            </div>
            <?= $form ?>
        </div>
    </section>
</main>