<?php

namespace App\Controller;

use App;
use App\Table\Category;
use Core\Controller\AbstarctController;
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
}
