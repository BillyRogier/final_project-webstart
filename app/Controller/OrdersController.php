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
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
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
                    for ($i = 0; $i < count($data['products']); $i++) {
                        if (!$ProductsTable->findOneBy(['id' => $data['products'][$i]])) {
                            $error->danger("error occured", "error_container");
                            break;
                        } else {
                            $OrdersTable
                                ->setUser_id($data['user'])
                                ->setProduct_id($data['products'][$i])
                                ->setQuantity($data['quantity'][$i])
                                ->setOrder_num($order_num)
                                ->flush();
                        }
                    }
                }

                $_SESSION["message"] = $error->success("successfully insert");
                $error->location(URL . "/admin/orders", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Orders::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Orders | Insert',
            'form' => $formBuilder->createView(),
        ]);
    }
}
