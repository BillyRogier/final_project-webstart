<h1>Admin page</h1>
<?php

use App\Table\Category;

foreach ($products as $product) : ?>
    <h3><?= $product->getName() ?></h3>
    <p><?= $product->getDescription() ?></p>
    <p><?= $product->getPrice() ?></p>
    <p><?= $product->getJoin(Category::class)->getCategory_name() ?></p>
    <a href="<?= URL ?>/admin/update/<?= $product->getId() ?>">update</a>
    <?=

    $form_delete
        ->change("id", ['value' => $product->getId()])
        ->change("submit", ['value' => 'delete'])
        ->createView()

    ?>
<?php endforeach; ?>