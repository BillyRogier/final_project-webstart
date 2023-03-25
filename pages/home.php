<h1>Home page</h1>

<div class="error_container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>

<?php

use App\Table\Category;

foreach ($products as $product) : ?>
    <h3><?= $product->getName() ?></h3>
    <p><?= $product->getDescription() ?></p>
    <p><?= $product->getPrice() ?></p>
    <p><?= $product->getJoin(Category::class)->getCategory_name() ?></p>
<?php endforeach; ?>