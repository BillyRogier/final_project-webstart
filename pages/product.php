<h1>Product page</h1>

<div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>

<?php

use App\Table\Category; ?>

<div class="carousel">
    <?php foreach ($carousel as $img) : ?>
        <img src="<?= URL ?>/assets/img/<?= $img->getImg() ?>" alt="">
    <?php endforeach ?>
</div>

<h3><?= $product->getName() ?></h3>
<p><?= $product->getDescription() ?></p>
<p><?= $product->getPrice() ?></p>
<p><?= $product->getJoin(Category::class)->getCategory_name() ?></p>
<?= $form_cart ?>