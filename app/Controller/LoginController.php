<?php

namespace App\Controller;

use App;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class LoginController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if ($this->app->isAdmin() || $this->app->isUser()) {
            $this->headLocation("/");
        }
    }

    #[Route('/login', name: 'login')]
    public function login()
    {
        $UsersTable = new Users();

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("email", EmailType::class, ['label' => "email", 'id' => "email"])
            ->add("password", PasswordType::class, ['label' => "password", 'id' => "password"])
            ->add("submit", SubmitType::class, ['value' => 'login'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $UsersTable->findOneBy(['email' => $data['email']]);

                if ($user) {
                    if (password_verify($data["password"], $user->getPassword())) {
                        $_SESSION["message"] = $error->success("successfully login");
                        if ($user->getType() == 2) {
                            $_SESSION['admin'] = $user->getId();
                        } else {
                            $_SESSION['user'] = $user->getId();
                        }
                        if (isset($_GET['cart']) && $_GET['cart'] == true) {
                            $error->location(URL . "/valid-user/" .  $_SESSION['valid'] . "", "success_location");
                        } else {
                            $error->location(URL . "/", "success_location");
                        }
                    } else {
                        $error->danger("Email or password incorrect", 'error_container');
                    }
                } else {
                    $error->danger("Email or password incorrect", 'error_container');
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/login.php', '/login.php', [
            'title' => 'Login',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register()
    {
        $UsersTable = new Users();

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
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
                    if (isset($_GET['cart']) && $_GET['cart'] == true) {
                        $error->location(URL . "/valid-user/" .  $_SESSION['valid'] . "", "success_location");
                    } else {
                        $error->location(URL . "/", "success_location");
                    }
                } else {
                    $error->danger("Email déjà utilisé", 'error_container');
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/register.php', '/login.php', [
            'title' => 'Register',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/logout', name: 'admin')]
    public function logout()
    {
        session_destroy();
        $this->headLocation("/");
    }
}
