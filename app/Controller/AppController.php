<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Products;
use Core\Controller\AbstarctController;
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
            ->leftJoin(Categorys::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $ProductsTable->findAllBy(["carousel.type" => 1], "OR carousel.type IS NULL");

        return $this->render('/app/home.php', '/default.php',  [
            'title' => 'Accueil',
            'products' => $products,
        ]);
    }
}
