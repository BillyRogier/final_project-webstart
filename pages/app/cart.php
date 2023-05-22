<div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>

<div>
    <?php

    use App\Table\Carousel;

    if (count($products_in_cart) >= 1) {
        foreach ($products_in_cart as $product) : ?>
            <img src="<?= URL ?>/assets/img/<?= $product['product']->getJoin(Carousel::class)->getImg() ?>" />
            <h1><?= $product['product']->getName() ?></h1>
            <p><?= $product['product']->getDescription() ?></p>
            <p><?= $product['product']->getPrice() ?></p>
            <?=
            $form
                ->change("id", ['value' => $product['product']->getId()])
                ->change("quantity", ['value' => $product['quantity'], 'class' => 'quantity'])
                ->createView()
            ?>
            <?=
            $form_del
                ->change("id", ['value' => $product['product']->getId()])
                ->createView()
            ?>
    <?php endforeach;
    } else {
        echo "No products in cart";
    } ?>
</div>