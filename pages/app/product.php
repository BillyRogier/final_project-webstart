<div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>

<div>
    <?php

    use App\Table\Carousel;

    foreach ($products as $product) : ?>
        <img src="<?= URL ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" />
    <?php endforeach; ?>
</div>

<h1><?= $product->getName() ?></h1>
<p><?= $product->getDescription() ?></p>
<p><?= $product->getPrice() ?></p>
<?php

if ($product->getVisibility() == 3) {
    echo "no stock";
} else {
    echo $form;
}

?>