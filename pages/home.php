<h1>Home page</h1>
<?php foreach ($products as $product) : ?>
    <h3><?= $product->getName() ?></h3>
    <p><?= $product->getDescription() ?></p>
    <p><?= $product->getPrice() ?></p>
    <p><?= $product->getJoin()->getCategory_name() ?></p>
<?php endforeach; ?>