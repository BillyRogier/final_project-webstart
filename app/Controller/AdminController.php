<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Category;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\DateTimeType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;
use DateTime;

class AdminController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->innerJoin(Category::class)
            ->on("products.category_id = category.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $ProductsTable->find("WHERE carousel.type = ? OR carousel.type IS ?", [1, NULL]);

        $form_delete = $this
            ->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'supprimer'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($ProductsTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                $carousel = $ProductsTable->getJoin(Carousel::class)->findAllBy(['product_id' => $data['id']]);
                $ProductsTable->getJoin(Carousel::class)->delete(['product_id' => $data['id']]);

                foreach ($carousel as $img) {
                    if (!$ProductsTable->getJoin(Carousel::class)->findAllBy(['img' => $img->getImg()])) {
                        unlink(ROOT . "/public/assets/img/" . $img->getImg());
                    }
                }

                $ProductsTable->delete(['id' => $data['id']]);

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/index.php', '/admin.php', [
            'title' => 'Admin | Accueil',
            'products' => $products,
            'form_delete' => $form_delete,
        ]);
    }

    #[Route('/admin/users', name: 'admin')]
    public function showUsers()
    {
        $UsersTable = new Users();
        $users = $UsersTable->findAll();

        $form_delete = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                if ($UsersTable->findOneBy(['id' => $data['id']])) {
                    $OrdersTable = new Orders();
                    $ReviewsTable = new Reviews();

                    $ReviewsTable->delete(['user_id' => $data['id']]);
                    $OrdersTable->delete(['user_id' => $data['id']]);
                    $UsersTable->delete(['id' => $data['id']]);

                    $_SESSION["message"] = $error->success("delete successfully");
                    $error->location(URL . "/admin/all-users", "success_location");
                } else {
                    $error->danger("error occured", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/users.php', '/admin.php', [
            'title' => 'Admin | Users',
            'users' => $users,
            'form_delete' => $form_delete
        ]);
    }

    #[Route('/admin/users/update/{id}', name: 'admin')]
    public function updateUser(int $id)
    {
        $UsersTable = $this->app->getTable('Users');
        $user = $UsersTable->findOneBy(['id' => $id]);

        if (!$user) {
            $this->headLocation("/admin/users");
        }

        $form_update = $this->createForm()
            ->add("id", HiddenType::class, ['value' => $id])
            ->add("first_name", TextType::class, ['value' => $user->getFirst_name(), 'data-req' => true])
            ->add("last_name", TextType::class, ['value' => $user->getLast_name(), 'data-req' => true])
            ->add("email", TextType::class, ['value' => $user->getEmail()])
            ->add("num", TextType::class, ['value' => $user->getNum(), 'data-req' => true])
            ->add("adress", TextType::class, ['value' => $user->getAdress(), 'data-req' => true])
            ->add("type", ChoiceType::class, ['choices' => ['Admin' => 1, 'Utilisateur' => 0], 'label' => 'Catégorie', 'id' => 'categorie'])
            ->add("creation_date", DateTimeType::class, ['value' => $user->getCreation_date()])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($form_update->isSubmit()) {
            $error = $form_update->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $form_update->getData();

                if ($data['type'] < 2) {
                    $user
                        ->setFirst_name($data['first_name'])
                        ->setLast_name($data['last_name'])
                        ->setEmail($data['email'])
                        ->setNum($data['num'])
                        ->setAdress($data['adress'])
                        ->setType($data['type'])
                        ->setCreation_date($data['creation_date'])
                        ->flush();

                    $_SESSION["message"] = $error->success("update successfully");
                    $error->location(URL . "/admin/users", "success_location");
                } else {
                    $error->success("error occured", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/user_update.php', '/admin.php', [
            'title' => 'Admin | Users | Update ' . $user->getFirst_name(),
            'form_update' => $form_update->createView(),
        ]);
    }
}
