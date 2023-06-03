<h1>Account</h1>

<div class="error_container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>

<?php

use App\Table\Carousel;
use App\Table\Products;

$order_container = "<div class=\"order_container\">";
for ($i = 0; $i < count($orders); $i++) :
    if (isset($orders[$i + 1]) && ($orders[$i]->getOrder_num() == $orders[$i + 1]->getOrder_num())) {
        $order_container .= " <a href=\"" . URL . "\product/" . $orders[$i]->getJoin(Products::class)->getId() . "\">
        <img src=\"" . URL . "/assets/img/" . $orders[$i]->getJoin(Carousel::class)->getImg()  . "\" />
        <h3>" . $orders[$i]->getJoin(Products::class)->getName() . "</h3>
        <p>" . $orders[$i]->getJoin(Products::class)->getDescription() . "</p>
        <p>" . $orders[$i]->getJoin(Products::class)->getPrice() . "</p>
        <p>" . $orders[$i]->getQuantity() . "</p>
        <a href=\"" . URL . "/add-comment\\" . $orders[$i]->getOrder_num() .  "/" . $orders[$i]->getJoin(Products::class)->getId() .  "\">Ajouter un commentaire</a>
        </a>";
    } else {
        echo $order_container . " <a href=\"" . URL . "\product/" . $orders[$i]->getJoin(Products::class)->getId() . "\">
        <img src=\"" . URL . "/assets/img/" . $orders[$i]->getJoin(Carousel::class)->getImg()  . "\" />
        <h3>" . $orders[$i]->getJoin(Products::class)->getName() . "</h3>
        <p>" . $orders[$i]->getJoin(Products::class)->getDescription() . "</p>
        <p>" . $orders[$i]->getJoin(Products::class)->getPrice() . "</p>
        <p>" . $orders[$i]->getQuantity() . "</p>
        <a href=\"" . URL . "/add-comment\\" . $orders[$i]->getOrder_num() .  "/" . $orders[$i]->getJoin(Products::class)->getId() .  "\">Ajouter un commentaire</a>
        </a></div>";
        $order_container = "<div class=\"order_container\">";
    } ?>
<?php endfor;
