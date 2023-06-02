<div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>

<div>
    <?php

    use App\Table\Carousel;

    $total = 0;
    if (count($products_in_cart) >= 1) {
        foreach ($products_in_cart as $product) :
            $product_total = $product['product']->getPrice() *  $product['quantity'];
            $total += $product_total; ?>
            <img src="<?= URL ?>/assets/img/<?= $product['product']->getJoin(Carousel::class)->getImg() ?>" />
            <h1><?= $product['product']->getName() ?></h1>
            <p><?= $product['product']->getDescription() ?></p>
            <p class="product_price"><?= $product['product']->getPrice() ?></p>
            <?=
            $form
                ->change("product_id", ['value' => $product['product']->getId()])
                ->change("quantity", ['value' => $product['quantity'], 'class' => 'quantity'])
                ->createView()
            ?>
            <?=
            $form_del
                ->change("id", ['value' => $product['product']->getId()])
                ->createView()
            ?>
            <div>
                total product :
                <p class="total_product"><?= $product_total ?></p>
            </div>
        <?php endforeach; ?>
        <div>total : <p class="total_cart"><?= $total ?></p>
        </div>
        <?php if ($loged) : ?>
            <a href="<?= URL ?>/valid-user/<?= $_SESSION['valid'] ?>">Valid cart</a>
        <?php else : ?>
            <a href="<?= URL ?>/login?cart=true">Valid cart</a>
        <?php endif ?>
    <?php } else {
        echo "No products in cart";
    }  ?>
</div>