<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Route\Route;

class AdminController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Categorys::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $ProductsTable->findAllBy(["carousel.type" => 1], "OR carousel.type IS NULL");

        $form_delete = $this
            ->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'supprimer'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($ProductsTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                $carousel = $ProductsTable->getJoin(Carousel::class)->findAllBy(['product_id' => $data['id']]);
                $ProductsTable->getJoin(Carousel::class)->delete(['product_id' => $data['id']]);

                foreach ($carousel as $img) {
                    if (!$ProductsTable->getJoin(Carousel::class)->findAllBy(['img' => $img->getImg()])) {
                        unlink(URL . "/public/assets/img/" . $img->getImg());
                    }
                }

                $ProductsTable->delete(['id' => $data['id']]);

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/index.php', '/admin.php', [
            'title' => 'Admin | Accueil',
            'products' => $products,
            'form_delete' => $form_delete,
        ]);
    }
}
