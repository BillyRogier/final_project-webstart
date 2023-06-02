<div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>

<div>
    <?php

    use App\Table\Carousel;
    use App\Table\Users;

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
} else if ($product->getVisibility() == 2) {
    echo "produit non disponible";
} else {
    echo $form;
}


foreach ($reviews as $review) : ?>
    <p><?= $review->getJoin(Users::class)->getFirst_name() ?></p>
    <p><?= $review->getJoin(Users::class)->getLast_name() ?></p>
    <p><?= $review->getGrade() ?></p>
    <p><?= $review->getDescription() ?></p>
<?php endforeach; ?>