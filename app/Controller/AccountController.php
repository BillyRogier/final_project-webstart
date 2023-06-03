<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\DateTimeType;
use Core\Form\Type\EmailType;
use Core\Form\Type\NumberType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class AccountController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->app->isAdmin() && !$this->app->isUser()) {
            $this->headLocation("/");
        }
    }

    #[Route('/account')]
    public function account()
    {
        $OrdersTable = new Orders();
        $OrdersTable
            ->innerJoin(Users::class)
            ->on("users.id = orders.user_id")
            ->innerJoin(Products::class)
            ->on("products.id = orders.product_id")
            ->innerJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $orders = $OrdersTable->findAllBy(['users.id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']), 'carousel.type' => 1]);

        return $this->render('/app/account_orders.php', '/default.php', [
            'title' => 'Account | Orders',
            'orders' => $orders,
        ]);
    }

    #[Route('/account/settings')]
    public function settings()
    {
        $UsersTable = new Users();
        $user = $UsersTable->findOneBy(['users.id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin'])]);

        if (!$user) {
            $this->headLocation("/account");
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("first_name", TextType::class, ['value' => $user->getFirst_name(), 'data-req' => true, 'label' => 'Prénom', 'id' => 'first_name'])
            ->add("last_name", TextType::class, ['value' => $user->getLast_name(), 'data-req' => true, 'label' => 'Nom', 'id' => 'last_name'])
            ->add("email", EmailType::class, ['value' => $user->getEmail(), 'label' => 'Email', 'id' => 'email'])
            ->add("password", PasswordType::class, ['label' => 'New password', 'id' => 'password'])
            ->add("num", TextType::class, ['value' => $user->getNum(), 'data-req' => true, 'label' => 'Numéro de téléphone', 'id' => 'num'])
            ->add("adress", TextType::class, ['value' => $user->getAdress(), 'data-req' => true, 'label' => 'Adresse', 'id' => 'adress'])
            ->add("type", ChoiceType::class, ['choices' => ['Admin' => 2, 'Utilisateur' => 1], 'label' => 'Type', 'id' => 'type', 'value' => $user->getType()])
            ->add("creation_date", DateTimeType::class, ['value' => $user->getCreation_date(), 'label' => 'Date de création', 'id' => 'creation_date'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();


        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                $user
                    ->setFirst_name($data['first_name'])
                    ->setLast_name($data['last_name'])
                    ->setEmail($data['email'])
                    ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))
                    ->setNum($data['num'])
                    ->setAdress($data['adress'])
                    ->flush();

                $_SESSION["message"] = $error->success("successfully update");
                $error->location(URL . "/account/settings", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/register.php', '/login.php', [
            'title' => 'Account | Settings',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/add-comment/{order_num}/{id}')]
    public function addComment($order_num, $id)
    {
        $OrdersTable = new Orders();
        if (!$OrdersTable->findOneBy(['order_num' => $order_num, 'user_id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']), 'product_id' => $id])) {
            $this->headLocation("/account");
        }
        $ProductsTable = new Products();
        $product = $ProductsTable->findOneBy(['id' => $id]);

        $ReviewsTable = new Reviews();

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("grade", NumberType::class, ['label' => 'Grade', 'id' => 'grade'])
            ->add("description", TextareaType::class, ['label' => 'Description', 'id' => 'description'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ReviewsTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                $ReviewsTable
                    ->setUser_id((isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']))
                    ->setProduct_id($id)
                    ->setDescription($data['description'])
                    ->setGrade($data['grade'])
                    ->flush();

                $_SESSION["message"] = $error->success("successfully insert");
                $error->location(URL . "/account", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Reviews::class));
        }

        return $this->render('/app/add_comment.php', '/default.php', [
            'title' => 'Add comment',
            'form' => $formBuilder->createView(),
        ]);
    }
}
