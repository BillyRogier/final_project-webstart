<h1>Admin page</h1>

<div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>

<a href="<?= URL ?>/admin/insert">add</a><br>

<?php

use App\Table\Carousel;
use App\Table\Categorys;

foreach ($products as $product) : ?>
    <div class="product">
        <img src="<?= URL ?>/assets/img/<?= $product->getJoin(Carousel::class)->getImg() ?>" />
        <h3><?= $product->getName() ?></h3>
        <p><?= $product->getDescription() ?></p>
        <p><?= $product->getPrice() ?></p>
        <p><?= $product->getJoin(Categorys::class)->getCategory_name() ?></p>
        <a href="<?= URL ?>/admin/update/<?= $product->getId() ?>">update</a>
        <?=

        $form_delete
            ->change("id", ['value' => $product->getId()])
            ->createView()

        ?>
    </div>
<?php endforeach; ?>