<?php

use App\Table\Products;
use App\Table\Users;

?>
<main class="grid" style="gap: 40px;">
    <div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
    <?php if (!empty($orders[0]->getJoin(Users::class)->getEmail())) : ?>
        <table class="table  user">
            <thead>
                <tr>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Num</th>
                    <th scope="col">Adress</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $orders[0]->getJoin(Users::class)->getFirst_name() ?></td>
                    <td><?= $orders[0]->getJoin(Users::class)->getLast_name() ?></td>
                    <td><?= $orders[0]->getJoin(Users::class)->getEmail() ?></td>
                    <td><?= $orders[0]->getJoin(Users::class)->getNum() ?></td>
                    <td><?= $orders[0]->getJoin(Users::class)->getAdress() ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif ?>
    <table class="table  order">
        <thead>
            <tr>
                <th scope="col">Order number</th>
                <th scope="col">Order date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $orders[0]->getOrder_num() ?></td>
                <td><?= $orders[0]->getOrder_date() ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table  products">
        <thead>
            <tr>
                <th scope="col">Product name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Product price</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $order->getJoin(Products::class)->getName() ?></td>
                    <td> <?= $order->getQuantity() ?></td>
                    <td>
                        <?= $order->getJoin(Products::class)->getPrice() ?>
                    </td>
                    <td>
                        <?= $order->getJoin(Products::class)->getPrice() * $order->getQuantity() ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>