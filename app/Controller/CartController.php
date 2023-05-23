<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Products;
use Core\Cart\Cart;
use Core\Controller\AbstarctController;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
use Core\Form\Type\SubmitType;
use Core\Route\Route;

class CartController extends AbstarctController
{
    private $app;

    public function __construct()
    {
        $this->app = App::getInstance();
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
            array_push($products_in_cart, ['product' => $product, 'quantity' => $value]);
        }

        $form_builder = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("quantity", NumberType::class, ['value' => '1'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            if (isset($_POST['quantity'])) {
                $error = $form_builder->isXmlValid($ProductsTable);
                if ($error->noError()) {
                    $data = $form_builder->getData();

                    if (array_key_exists($data['id'], $Cart->getCart())) {
                        $Cart->setQuantity($data['id'], $data['quantity']);
                    }
                }
                $error->getXmlMessage("");
            }
        }

        $form_delete = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'delete'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            if (isset($_POST['id'])) {
                $error = $form_delete->isXmlValid($ProductsTable);
                if ($error->noError()) {
                    $data = $form_delete->getData();

                    $Cart->removeFromCart($data['id']);

                    $_SESSION["message"] = $error->success("successfully delete from cart");
                    $error->location(URL . "/cart", "success_location");
                }
                $error->getXmlMessage("");
            }
        }

        return $this->render('/app/cart.php', '/default.php',  [
            'title' => 'Cart',
            'products_in_cart' => $products_in_cart,
            'form' => $form_builder,
            'form_del' => $form_delete,
        ]);
    }

    #[Route('/buy')]
    public function validCart()
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $Cart = new Cart();
        $products_in_cart = [];

        foreach ($Cart->getCart() as $key => $value) {
            $product = $ProductsTable->findOneBy(["products.id" => $key, "carousel.type" => 1]);
            array_push($products_in_cart, ['product' => $product, 'quantity' => $value]);
        }

        $form_builder = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("quantity", NumberType::class, ['value' => '1'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            if (isset($_POST['quantity'])) {
                $error = $form_builder->isXmlValid($ProductsTable);
                if ($error->noError()) {
                    $data = $form_builder->getData();

                    if (array_key_exists($data['id'], $Cart->getCart())) {
                        $Cart->setQuantity($data['id'], $data['quantity']);
                    }
                }
                $error->getXmlMessage("");
            }
        }

        return $this->render('/app/cart.php', '/default.php',  [
            'title' => 'Cart',
            'products_in_cart' => $products_in_cart,
            'form' => $form_builder,
        ]);
    }
}
