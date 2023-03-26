<h1>Home page</h1>

<div class="error_container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>

<?php

use App\Table\Carousel;
use App\Table\Category;

foreach ($products as $product) : ?>
    <a href="<?= URL ?>/product/<?= $product->getId() ?>">
        <img src="<?= URL ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" />
        <h3><?= $product->getName() ?></h3>
        <p><?= $product->getDescription() ?></p>
        <p><?= $product->getPrice() ?></p>
        <p><?= $product->getJoin(Category::class)->getCategory_name() ?></p>
    </a>
<?php endforeach; ?>