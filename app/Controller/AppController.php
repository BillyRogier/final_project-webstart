<?php

namespace App\Controller;

use App;
use App\Cart\Cart;
use App\Table\Carousel;
use App\Table\Category;
use App\Table\Products;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Response\Response;
use Core\Route\Route;

class AppController extends AbstarctController
{
    private $app;
    private $cookie_cart;

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->cookie_cart = new Cart();
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        $productsTable = $this->app->getTable('Products');
        $productsTable
            ->innerJoin(Category::class)
            ->on("products.category_id = category.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $productsTable->findAllBy(['carousel.type' => 1], ['carousel.type' => NULL]);

        return $this->render('/home.php', '/default.php',  [
            'title' => 'Accueil',
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product')]
    public function product(int $id): Response
    {
        $productsTable = $this->app->getTable('Products');
        $carouselsTable = $this->app->getTable('Carousel');

        $productsTable
            ->innerJoin(Category::class)
            ->on("products.category_id = category.category_id");

        $product = $productsTable->findOneBy(['id' => $id]);
        $carousel = $carouselsTable->findAllBy(['product_id' => $id]);

        $form_cart = $this->createForm()
            ->add("id", HiddenType::class, ['value' => $id])
            ->add("add_to_cart", SubmitType::class, ['value' => 'add to cart']);

        if ($form_cart->isSubmit()) {
            $error = $form_cart->isXmlValid($productsTable);
            if ($error->noError()) {
                $data = $form_cart->getData();

                $this->cookie_cart->addToCart($data["id"], 1);

                $_SESSION["message"] = $error->success("successfully");
                $error->location(URL . "/product/$id", "success_location");
                $error->getXmlMessage($this->app->getProperties(Users::class));
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/product.php', '/default.php',  [
            'title' => 'Accueil',
            'product' => $product,
            'carousel' => $carousel,
            'form_cart' => $form_cart->createView(),
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
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
            'title' => 'Login',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
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
            'title' => 'Register',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/account', name: 'account')]
    public function account(): Response
    {
        if (!$this->app->isUser() && !$this->app->isAdmin()) {
            $this->headLocation("/login");
        } else {
            $user_id = $this->app->isUser() || $this->app->isAdmin();
        }

        $usersTable = $this->app->getTable('Users');
        $ordersTable = $this->app->getTable('Orders');

        $ordersTable
            ->join(Products::class)
            ->on("products.id = orders.product_id");

        $user = $usersTable->findOneBy(["id" => $user_id]);
        $orders = $ordersTable->findAllBy(['user_id' => $user_id], "order_date DESC");

        $form_user = $this->createForm()
            ->add("first_name", TextType::class, ['value' => $user->getFirst_name()])
            ->add("last_name", TextType::class, ['value' => $user->getLast_name()])
            ->add("email", EmailType::class, ['value' => $user->getEmail()])
            ->add("password", PasswordType::class)
            ->add("num", TextType::class, ['value' => $user->getNum()])
            ->add("adress", TextType::class, ['value' => $user->getAdress()])
            ->add("save", SubmitType::class, ['value' => 'save']);

        return $this->render('/account.php', '/default.php', [
            'title' => 'Account',
            'orders' => $orders,
            'form_user' => $form_user->createView(),
        ]);
    }

    #[Route('/cart', name: 'cart')]
    public function cart(): Response
    {
        $productsTable = $this->app->getTable('Products');
        $productsTable
            ->innerJoin(Category::class)
            ->on("products.category_id = category.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $productsTable->findAllBy(['carousel.type' => 1], ['carousel.type' => NULL, 'products.id' => 8]);
        var_dump($products);

        return $this->render('/cart.php', '/default.php', [
            'title' => 'Cart',
        ]);
    }
}
