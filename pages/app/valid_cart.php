<div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>

<?php

use App\Table\Carousel;

echo $user->getFirst_name();
echo $user->getLast_name();
echo $user->getAdress();

$total = 0;

foreach ($products_in_cart as $product) :
    $product_total = $product['product']->getPrice() *  $product['quantity'];
    $total += $product_total; ?>
    <img src="<?= URL ?>/assets/img/<?= $product['product']->getJoin(Carousel::class)->getImg() ?>" />
    <h1><?= $product['product']->getName() ?></h1>
    <p><?= $product['product']->getDescription() ?></p>
    <p class="product_price"><?= $product['product']->getPrice() ?></p>
    <div>
        total product :
        <p class="total_product"><?= $product_total ?></p>
    </div>
<?php endforeach; ?>

<div>
    total :
    <p class="total_cart"><?= $total ?></p>
</div>
<?= $form ?>