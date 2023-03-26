<?php

use App\Table\Products;

foreach ($orders as $order) :
    $product = $order->getJoin(Products::class); ?>
    <div class="order-info">
        <p>Order date : <?= $order->getOrder_date() ?></p>
        <p>Package number : <?= $order->getPackage_num() ?></p>
    </div>
    <h3><?= $product->getName() ?></h3>
    <p><?= $product->getDescription() ?></p>
    <p><?= $product->getPrice() ?></p>
<?php endforeach ?>

<h2>User insformation</h2>
<?= $form_user ?>