<?php

namespace App\Controller;

use App;
use App\Table\Category;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Response\Response;
use Core\Route\Route;

class AppController extends AbstarctController
{
    private $app;

    public function __construct()
    {
        $this->app = App::getInstance();
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        $productsTable = $this->app->getTable('Products');
        $productsTable
            ->join(Category::class)
            ->on("products.category_id = category.category_id");

        $products = $productsTable->findAll();

        return $this->render('/home.php', '/default.php',  [
            'title' => 'Accueil',
            'products' => $products,
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login()
    {
        $usersTable = $this->app->getTable('Users');

        $formBuilder = $this
            ->createForm()
            ->add("email", EmailType::class)
            ->add("password", PasswordType::class)
            ->add("submit", SubmitType::class, ['value' => 'login'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($usersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $usersTable->findOneBy(['email' => $data['email']]);

                if ($user) {
                    if (password_verify($data["password"], $user->getPassword())) {
                        if ($user->getType() == 1) {
                            $_SESSION['admin'] = $user->getId();
                        } else {
                            $_SESSION['user'] = $user->getId();
                        }
                    } else {
                        $error->danger("Email or password incorrect", 'error_container');
                    }
                } else {
                    $error->danger("Email or password incorrect", 'error_container');
                }

                if ($error->noError()) {
                    $_SESSION["message"] = $error->success("successfully login");
                    $error->location(URL . "/", "success_location");
                    $error->getXmlMessage($this->app->getProperties(Users::class));
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/login.php', '/login.php', [
            'title' => 'admin | login',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register()
    {
        $usersTable = $this->app->getTable('Users');

        $formBuilder = $this
            ->createForm()
            ->add("email", EmailType::class)
            ->add("password", PasswordType::class)
            ->add("submit", SubmitType::class, ['value' => 'register'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($usersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $usersTable->findOneBy(['email' => $data['email']]);

                if ($user) {
                    $error->danger("Email already associated to an account", 'error_container');
                } else {
                    $usersTable
                        ->setEmail($data["email"])
                        ->setPassword(password_hash($data["password"], PASSWORD_DEFAULT))
                        ->flush();

                    $userid = $usersTable->lastInsertId();
                    $_SESSION['user'] = $userid;
                }

                if ($error->noError()) {
                    $_SESSION["message"] = $error->success("account create successfully");
                    $error->location(URL . "/", "success_location");
                    $error->getXmlMessage($this->app->getProperties(Users::class));
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/login.php', '/login.php', [
            'title' => 'admin | login',
            'form' => $formBuilder->createView(),
        ]);
    }
}
