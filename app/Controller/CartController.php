<?php

namespace App\Controller;

use App\Table\Carousel;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Users;
use Core\Cart\Cart;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class CartController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
    }

    #[Route('/cart')]
    public function cart()
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $Cart = new Cart();
        $products_in_cart = [];

        foreach ($Cart->getCart() as $key => $value) {
            $product = $ProductsTable->findOneBy(["products.id" => $key, "carousel.type" => 1]);
            if ($product) {
                array_push($products_in_cart, ['product' => $product, 'quantity' => $value]);
            }
        }

        $form_builder = $this->createForm()
            ->add("product_id", HiddenType::class)
            ->add("quantity", NumberType::class, ['value' => '1'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            if (isset($_POST['quantity'])) {
                $error = $form_builder->isXmlValid($ProductsTable);
                if ($error->noError()) {
                    $data = $form_builder->getData();

                    if (array_key_exists($data['product_id'], $Cart->getCart())) {
                        $Cart->setQuantity($data['product_id'], $data['quantity']);
                    }
                }
                $error->getXmlMessage($Cart->countItems());
            }
        }

        $form_delete = $this->createForm("", "post", ['class' => 'form_delete'])
            ->add("id", HiddenType::class)
            ->add("delete_btn", SubmitType::class, ['value' => 'supprimer', 'class' => 'delete_btn'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            if (isset($_POST['id']) && !isset($_POST['quantity'])) {
                $error = $form_delete->isXmlValid($ProductsTable);
                if ($error->noError()) {
                    $data = $form_delete->getData();

                    $Cart->removeFromCart($data['id']);

                    $error->location(URL . "/cart", "success_location");
                }
                $error->getXmlMessage("");
            }
        }
        $_SESSION['valid'] =  uniqid();

        $ProductsTable
            ->leftJoin(Orders::class)
            ->on("products.id = orders.product_id");

        $products_trends = $ProductsTable->find("
        products.id, products.name, products.price, carousel.img, SUM(orders.quantity) AS total_quantity", "
        WHERE products.visibility = 1 AND carousel.type = 1
        GROUP BY products.id, products.name, products.price, carousel.img
        ORDER BY total_quantity DESC
        LIMIT 8;");

        return $this->render('/app/cart.php', '/default.php',  [
            'title' => 'Cart',
            'products_in_cart' => $products_in_cart,
            'count_items' => $Cart->countItems(),
            'form' => $form_builder,
            'form_del' => $form_delete,
            'products_trends' => $products_trends,
            'loged' => ($this->app->isUser() || $this->app->isAdmin()),
        ]);
    }

    #[Route('/valid-user/{id}')]
    public function validUser($id)
    {
        if ($id != $_SESSION['valid']) {
            $this->headLocation("/");
        }

        $UsersTable = new Users();

        if ($this->app->isUser() || $this->app->isAdmin()) {
            $user = $UsersTable->findOneBy(['id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin'])]);
        }

        $form_builder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("last_name", TextType::class, ['value' => (isset($user) ? $user->getLast_name() : ""), 'label' => 'Nom', 'id' => 'last_name'])
            ->add("first_name", TextType::class, ['value' => (isset($user) ? $user->getFirst_name() : ""), 'label' => 'Prénom', 'id' => 'first_name'])
            ->add("email", EmailType::class, ['value' => (isset($user) ? $user->getEmail() : ""), 'label' => 'Email', 'id' => 'email'])
            ->add("num", TextType::class, ['value' => (isset($user) ? $user->getNum() : ""), 'data-req' => true, 'label' => 'Numéro de téléphone', 'id' => 'num'])
            ->add("adress", TextType::class, ['value' => (isset($user) ? $user->getAdress() : ""), 'label' => 'Adresse', 'id' => 'adress'])
            ->add("submit", SubmitType::class, ['value' => 'Continuer', 'class' => 'btn'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            $error = $form_builder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $form_builder->getData();

                $user_email = $UsersTable->findOneBy(['email' => $data['email']], "AND id != " . (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']) . "");

                if (!$user_email) {
                    $user
                        ->setFirst_name($data['first_name'])
                        ->setLast_name($data['last_name'])
                        ->setEmail($data['email'])
                        ->setNum($data['num'])
                        ->setAdress($data['adress'])
                        ->flush();
                } else {
                    $error->danger("Email déjà utilisé", 'error_container');
                }

                $error->location(URL . "/valid-cart/" . $_SESSION['valid'] . "", "success_location");
            }
            $error->getXmlMessage(Users::class);
        }

        return $this->render('/app/valid_user.php', '/default.php',  [
            'title' => 'Valid user',
            'form' => $form_builder->createView(),
        ]);
    }

    #[Route('/valid-cart/{id}')]
    public function validCart($id)
    {
        if ($id != $_SESSION['valid']) {
            $this->headLocation("/");
        }

        $UsersTable = new Users();
        $user = $UsersTable->findOneBy(['id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin'])]);

        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $Cart = new Cart();
        $products_in_cart = [];

        foreach ($Cart->getCart() as $key => $value) {
            $product = $ProductsTable->findOneBy(["products.id" => $key, "carousel.type" => 1]);
            if ($product) {
                array_push($products_in_cart, ['product' => $product, 'quantity' => $value]);
            }
        }


        $form_builder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("submit", SubmitType::class, ['value' => 'Valider la commande', 'class' => 'btn'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            $error = $form_builder->isXmlValid();
            if ($error->noError()) {
                $data = $form_builder->getData();

                $OrdersTable = new Orders();

                $order_num =  bin2hex(random_bytes(16));

                foreach ($products_in_cart as $product) {
                    $OrdersTable
                        ->setUser_id($user->getId())
                        ->setProduct_id($product["product"]->getId())
                        ->setQuantity($product["quantity"])
                        ->setOrder_num($order_num)
                        ->setOrder_date(date('Y-m-d H:i:s'))
                        ->flush();
                }

                $Cart->cleanCart();
                $error->location(URL . "/", "success_location");
            }
            $error->getXmlMessage("");
        }


        return $this->render('/app/valid_cart.php', '/default.php',  [
            'title' => 'Valid user',
            'products_in_cart' => $products_in_cart,
            'count_items' => $Cart->countItems(),
            'user' => $user,
            'form' => $form_builder->createView(),
        ]);
    }
}
