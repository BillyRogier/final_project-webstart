<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Category;
use App\Table\Products;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class AppController extends AbstarctController
{
    private $app;

    public function __construct()
    {
        $this->app = App::getInstance();
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->innerJoin(Category::class)
            ->on("products.category_id = category.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $ProductsTable->find("WHERE carousel.type = ? OR carousel.type IS ?", [1, NULL]);

        return $this->render('/app/home.php', '/default.php',  [
            'title' => 'Accueil',
            'products' => $products,
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login()
    {
        if ($this->app->isAdmin() || $this->app->isUser()) {
            $this->headLocation("/");
        }

        $UsersTable = new Users();

        $formBuilder = $this->createForm()
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
                        if ($user->getType() == 1) {
                            $_SESSION['admin'] = $user->getId();
                        } else {
                            $_SESSION['user'] = $user->getId();
                        }
                        $error->location(URL . "/", "success_location");
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
        if ($this->app->isAdmin() || $this->app->isUser()) {
            $this->headLocation("/");
        }

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
            'title' => 'Register',
            'form' => $formBuilder->createView(),
        ]);
    }
}
