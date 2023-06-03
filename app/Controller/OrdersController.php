<?php

namespace App\Controller;

use App;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
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
            ->innerJoin(Users::class)
            ->on("orders.user_id = users.id");
        $orders = $OrdersTable->find("*", "ORDER BY orders.order_num");

        $form_delete = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer'])
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

    #[Route('/admin/orders/insert')]
    public function insertOrder()
    {
        $UsersTable = new Users();
        $users = $UsersTable->findAll();

        $users_choices = [];
        foreach ($users as $user) {
            $users_choices[$user->getEmail()] = $user->getId();
        }

        $ProductsTable = new Products();
        $products = $ProductsTable->findAll();

        $products_choices = [];
        foreach ($products as $product) {
            $products_choices[$product->getName()] = $product->getId();
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("user", ChoiceType::class, ['label' => 'Users', 'id' => 'user', 'choices' => $users_choices])
            ->addHTML("<div class=\"product-container\">")
            ->add("products[]", ChoiceType::class, ['label' => 'Products', 'id' => uniqid(), 'choices' => $products_choices])
            ->add("quantity[]", NumberType::class, ['label' => 'Quantity', 'id' => uniqid(), 'value' => 1])
            ->addHTML("</div>")
            ->addHTML("<span class=\"add_prdt\">add product</span>")
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $OrdersTable = new Orders();
            $error = $formBuilder->isXmlValid($OrdersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if (!$UsersTable->findOneBy(['id' => $data['user']])) {
                    $error->danger("error occured", "error_container");
                } else {
                    $order_num = uniqid();
                    $product_quantity = [];

                    for ($i = 0; $i < count($data['products']); $i++) {
                        if (!$ProductsTable->findOneBy(['id' => $data['products'][$i]])) {
                            $error->danger("error occured", "error_container");
                            $error->getXmlMessage($this->app->getProperties(Orders::class));
                        } else {
                            if (isset($product_quantity[$data['products'][$i]])) {
                                $product_quantity[$data['products'][$i]] += $data['quantity'][$i];
                            } else {
                                $product_quantity[$data['products'][$i]] = $data['quantity'][$i];
                            }
                        }
                    }

                    foreach ($product_quantity as $key => $value) {
                        $OrdersTable
                            ->setUser_id($data['user'])
                            ->setProduct_id($key)
                            ->setQuantity($value)
                            ->setOrder_num($order_num)
                            ->flush();
                    }

                    $_SESSION["message"] = $error->success("successfully insert");
                    $error->location(URL . "/admin/orders", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Orders::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Orders | Insert',
            'form' => $formBuilder->createView(),
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

    #[Route('/admin/orders/update/{id}')]
    public function updateOrder($id)
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

        $users = $OrdersTable->getJoin(Users::class)->findAll();

        $users_choices = [];
        foreach ($users as $user) {
            $users_choices[$user->getEmail()] = $user->getId();
        }

        $products = $OrdersTable->getJoin(Products::class)->findAll();

        $products_choices = [];
        foreach ($products as $product) {
            $products_choices[$product->getName()] = $product->getId();
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("user", ChoiceType::class, ['label' => 'Users', 'id' => 'user', 'choices' => $users_choices]);

        foreach ($orders as $order) {
            $formBuilder
                ->addHTML("<div class=\"product-container\">")
                ->addContainer(
                    "product-container",
                    [
                        ["products[]", ChoiceType::class, ['label' => 'Products', 'value' => $order->getJoin(Products::class)->getId(), 'id' => uniqid(), 'choices' => $products_choices]],
                        ["quantity[]", NumberType::class, ['label' => 'Quantity', 'id' => uniqid(), 'value' => $order->getQuantity()]]
                    ]
                )
                ->addHTML("</div>");
        }

        $formBuilder
            ->addHTML("<span class=\"add_prdt\">add product</span>")
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($OrdersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if (!$OrdersTable->getJoin(Users::class)->findOneBy(['id' => $data['user']])) {
                    $error->danger("error occured", "error_container");
                } else {
                    $order_num = $id;
                    $order_date = $orders[0]->getOrder_date();
                    $product_quantity = [];

                    for ($i = 0; $i < count($data['products']); $i++) {
                        if (!$OrdersTable->getJoin(Products::class)->findOneBy(['id' => $data['products'][$i]])) {
                            $error->danger("error occured", "error_container");
                            $error->getXmlMessage($this->app->getProperties(Orders::class));
                        } else {
                            if (isset($product_quantity[$data['products'][$i]])) {
                                $product_quantity[$data['products'][$i]] += $data['quantity'][$i];
                            } else {
                                $product_quantity[$data['products'][$i]] = $data['quantity'][$i];
                            }
                        }
                    }

                    $OrdersTable->delete(['order_num' => $id]);

                    foreach ($product_quantity as $key => $value) {
                        $OrdersTable
                            ->setUser_id($data['user'])
                            ->setProduct_id($key)
                            ->setQuantity($value)
                            ->setOrder_num($order_num)
                            ->setOrder_date($order_date)
                            ->flush();
                    }

                    $_SESSION["message"] = $error->success("successfully update");
                    $error->location(URL . "/admin/orders", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Orders::class));
        }


        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Orders | Update',
            'orders' => $orders,
            'form' => $formBuilder->createView(),
        ]);
    }
}
