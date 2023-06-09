<?php

namespace App\Controller;

use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Users;
use Core\Cart\Cart;
use Core\Controller\AbstarctController;
use Core\Form\Type\NumberType;
use Core\Form\Type\SubmitType;
use Core\Route\Route;

class AppController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
    }

    #[Route('/')]
    public function home()
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Categorys::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $categorys = $ProductsTable->getJoin(Categorys::class)->findAll();

        $products = $ProductsTable->findAllBy(["carousel.type" => 1], "AND products.visibility != 2 OR carousel.type IS NULL");

        return $this->render('/app/home.php', '/default.php',  [
            'title' => 'Accueil',
            'products' => $products,
            'categorys' => $categorys,
        ]);
    }


    #[Route('/product/{id}')]
    public function viewProduct(int $id)
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Categorys::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $ProductsTable->findAllBy(['products.id' => $id]);

        if (!$products) {
            $this->headLocation("/");
        }

        $form_builder = $this->createForm("", "post", ['class' => 'add_to_cart'])
            ->add("quantity", NumberType::class, ['label' => 'Quantity', 'id' => 'quantity', 'value' => '1'])
            ->add("submit", SubmitType::class, ['value' => 'add to cart'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            $error = $form_builder->isXmlValid($ProductsTable);
            if ($error->noError()) {
                $data = $form_builder->getData();

                $Cart = new Cart();
                $Cart->addToCart($id, $data['quantity']);
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        $ReviewsTable = new Reviews();
        $ReviewsTable
            ->leftJoin(Users::class)
            ->on("reviews.user_id = users.id");
        $reviews = $ReviewsTable->findAllBy(['reviews.product_id' => $id]);

        return $this->render('/app/product.php', '/default.php',  [
            'title' => 'Product',
            'products' => $products,
            'reviews' => $reviews,
            'form' => $form_builder->createView(),
        ]);
    }

    #[Route('/category/{category}')]
    public function category($category)
    {
        $CategorysTable = new Categorys();
        $CategorysTable
            ->leftJoin(Products::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products =
            $category == "all-products" ?
            $CategorysTable->findAllBy(["carousel.type" => 1], "AND products.visibility != 2 OR carousel.type IS NULL") :
            $CategorysTable->findAllBy(["carousel.type" => 1, "categorys.category_name" => $category], "AND products.visibility != 2 OR carousel.type IS NULL");


        return $this->render('/app/category.php', '/default.php',  [
            'title' => str_replace("-", " ", ucfirst($category)),
            'subtitle' => $category,
            'category_img' => $products[0]->getCategory_img(),
            'products' => $products,
        ]);
    }
}
