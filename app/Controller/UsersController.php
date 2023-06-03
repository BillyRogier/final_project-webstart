<?php

namespace App\Controller;

use App;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\DateTimeType;
use Core\Form\Type\EmailType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class UsersController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin/users', name: 'show all users')]
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
                    $error->location(URL . "/admin/users", "success_location");
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

    #[Route('/admin/users/insert', name: 'insert user')]
    public function insertUser()
    {
        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("first_name", TextType::class, ['label' => 'First name', 'id' => 'first_name', 'data-req' => true])
            ->add("last_name", TextType::class, ['label' => 'Last name', 'id' => 'last_name', 'data-req' => true])
            ->add("email", EmailType::class, ['label' => 'Email', 'id' => 'email'])
            ->add("password", PasswordType::class, ['label' => 'Password', 'id' => 'password', 'data-pass' => true])
            ->add("num", TextType::class, ['label' => 'Phone number', 'id' => 'num', 'data-req' => true])
            ->add("adress", TextType::class, ['label' => 'Adress', 'id' => 'adress', 'data-req' => true])
            ->add("type", ChoiceType::class, ['choices' => ['Admin' => 2, 'Utilisateur' => 1], 'label' => 'Type', 'id' => 'type'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $UsersTable = new Users();
            $error = $formBuilder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $UsersTable->findOneBy(['email' => $data['email']]);


                if (!$user) {
                    if ($data['type'] == 1 || $data['type'] == 2) {
                        $UsersTable
                            ->setFirst_name($data['first_name'])
                            ->setLast_name($data['last_name'])
                            ->setEmail($data['email'])
                            ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))
                            ->setNum($data['num'])
                            ->setAdress($data['adress'])
                            ->setType($data['type'])
                            ->flush();

                        $_SESSION["message"] = $error->success("successfully register");
                        $error->location(URL . "/admin/users", "success_location");
                    } else {
                        $error->danger("error occured", "error_container");
                    }
                } else {
                    $error->danger("Email déjà utilisé", 'error_container');
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Register',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin/users/update/{id}', name: 'update user')]
    public function updateUser(int $id)
    {
        $UsersTable = new Users();
        $user = $UsersTable->findOneBy(['id' => $id]);

        if (!$user) {
            $this->headLocation("/admin/users");
        }

        $form_update = $this->createForm("", "post", ['class' => 'grid'])
            ->add("first_name", TextType::class, ['value' => $user->getFirst_name(), 'data-req' => true, 'label' => 'Prénom', 'id' => 'first_name'])
            ->add("last_name", TextType::class, ['value' => $user->getLast_name(), 'data-req' => true, 'label' => 'Nom', 'id' => 'last_name'])
            ->add("email", EmailType::class, ['value' => $user->getEmail(), 'label' => 'Email', 'id' => 'email'])
            ->add("num", TextType::class, ['value' => $user->getNum(), 'data-req' => true, 'label' => 'Numéro de téléphone', 'id' => 'num'])
            ->add("adress", TextType::class, ['value' => $user->getAdress(), 'data-req' => true, 'label' => 'Adresse', 'id' => 'adress'])
            ->add("type", ChoiceType::class, ['choices' => ['Admin' => 2, 'Utilisateur' => 1], 'label' => 'Type', 'id' => 'type', 'value' => $user->getType()])
            ->add("creation_date", DateTimeType::class, ['value' => $user->getCreation_date(), 'label' => 'Date de création', 'id' => 'creation_date'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($form_update->isSubmit()) {
            $error = $form_update->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $form_update->getData();

                if ($data['type'] == 1 || $data['type'] == 2) {
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
                    $error->danger("error occured", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/admin/user_update.php', '/admin.php', [
            'title' => 'Admin | Users | Update ' . $user->getFirst_name(),
            'form_update' => $form_update->createView(),
        ]);
    }
}
