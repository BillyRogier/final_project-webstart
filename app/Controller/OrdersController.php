<?php

namespace App\Controller;

use App\Table\Orders;
use App\Table\Products;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Route\Route;

class OrdersController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin/orders')]
    public function showOrders()
    {
        $OrdersTable = new Orders();
        $OrdersTable
            ->innerJoin(Users::class);
        $orders = $OrdersTable->find("*", "ORDER BY orders.order_date DESC");

        return $this->render('/admin/orders.php', '/admin.php', [
            'title' => 'Admin | Orders',
            'orders' => $orders,
        ]);
    }

    #[Route('/admin/orders/view/{id}')]
    public function viewOrder($id)
    {
        $OrdersTable = new Orders();
        $OrdersTable
            ->leftJoin(Users::class)
            ->on("orders.user_id = users.id")
            ->innerJoin(Products::class)
            ->on("products.id = orders.product_id");
        $orders = $OrdersTable->findAllBy(["order_num" => $id]);

        if (!$orders) {
            $this->headLocation("/admin/orders");
        }

        return $this->render('/admin/order_view.php', '/admin.php', [
            'title' => 'Admin | Orders',
            'orders' => $orders,
        ]);
    }
}
