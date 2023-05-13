<?php

namespace App\Controller;

use App;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Route\Route;

class AccountController extends AbstarctController
{
    private $app;

    public function __construct()
    {
        $this->app = App::getInstance();
        if (!$this->app->isAdmin() || !$this->app->isUser()) {
            $this->headLocation("/");
        }
    }

    #[Route('/account', name: 'account')]
    public function account()
    {
        // select all order from this user
        $OrdersTable = new Orders();
        $OrdersTable
            ->innerJoin(Users::class)
            ->on("users.id = orders.user_id")
            ->innerJoin(Products::class)
            ->on("products.id = orders.product_id");
        $orders = $OrdersTable->findAllBy(['users.id' => isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']]);

        return $this->render('/app/register.php', '/login.php', [
            'title' => 'Account | Order',
        ]);
    }

    #[Route('/account/settings', name: 'account')]
    public function settings()
    {
        $UsersTable = new Users();

        $formBuilder = $this->createForm()
            ->add("first_name", TextType::class, ['label' => 'First name', 'id' => 'first_name', 'data-req' => true])
            ->add("last_name", TextType::class, ['label' => 'Last name', 'id' => 'last_name', 'data-req' => true])
            ->add("email", EmailType::class, ['label' => 'Email', 'id' => 'email'])
            ->add("password", PasswordType::class, ['label' => 'Password', 'id' => 'password', 'data-pass' => true])
            ->add("num", TextType::class, ['label' => 'Phone number', 'id' => 'num', 'data-req' => true])
            ->add("adress", TextType::class, ['label' => 'Adress', 'id' => 'adress', 'data-req' => true])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $UsersTable->findOneBy(['email' => $data['email']]);

                if (!$user) {
                    $UsersTable
                        ->setFirst_name($data['first_name'])
                        ->setLast_name($data['last_name'])
                        ->setEmail($data['email'])
                        ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))
                        ->setNum($data['num'])
                        ->setAdress($data['adress'])
                        ->flush();

                    $_SESSION['user'] = $UsersTable->lastInsertId();
                    $_SESSION["message"] = $error->success("successfully register");
                    $error->location(URL . "/", "success_location");
                } else {
                    $error->danger("Email déjà utilisé", 'error_container');
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/register.php', '/login.php', [
            'title' => 'Account | Settings',
            'form' => $formBuilder->createView(),
        ]);
    }
}
