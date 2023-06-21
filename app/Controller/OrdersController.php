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
        $orders = $OrdersTable->find("*", "ORDER BY orders.order_num");

        $form_delete = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer', 'class' => 'btn del'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($OrdersTable);
            if ($error->noError()) {
                $data = $form_delete->getData();
                if ($OrdersTable->findOneBy(['order_num' => $data['id']])) {
                    $OrdersTable->delete(['order_num' => $data['id']]);
                    $_SESSION["message"] = $error->success("delete successfully");
                    $error->location(URL . "/admin/orders", "success_location");
                } else {
                    $error->danger("error occured", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Orders::class));
        }

        return $this->render('/admin/orders.php', '/admin.php', [
            'title' => 'Admin | Orders',
            'orders' => $orders,
            'form_delete' => $form_delete
        ]);
    }

    #[Route('/admin/orders/view/{id}')]
    public function viewOrder($id)
    {
        $OrdersTable = new Orders();
        $OrdersTable
            ->innerJoin(Users::class)
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
