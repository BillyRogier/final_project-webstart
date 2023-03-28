<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Category;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Route\Route;


class AdminController extends AbstarctController
{
    private $app;

    public function __construct()
    {
        $this->app = App::getInstance();
    }

    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }
        $productsTable = $this->app->getTable('Products');
        $carouselTable = $this->app->getTable('Carousel');
        $productsTable
            ->innerJoin(Category::class)
            ->on("products.category_id = category.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products = $productsTable->find("WHERE carousel.type = ? OR carousel.type IS ?", [1, NULL]);

        $form_delete = $this
            ->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class)
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($productsTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                $carouselTable->delete(['product_id' => $data['id']]);
                $productsTable->delete(['id' => $data['id']]);

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin", "success_location");
                $error->getXmlMessage($this->app->getProperties(Products::class));
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/index.php', '/admin.php', [
            'title' => 'admin | Accueil',
            'products' => $products,
            'form_delete' => $form_delete,
        ]);
    }

    #[Route('/admin/update/{id}', name: 'update')]
    public function update(int $id)
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }

        $productsTable = $this->app->getTable('Products');
        $carouselTable = $this->app->getTable('Carousel');
        $categoryTable = $this->app->getTable('Category');

        $productsTable
            ->join(Category::class)
            ->on("products.category_id = category.category_id");

        $product = $productsTable->findOneBy(['products.id' => $id]);
        $carousel = $carouselTable->findAllBy(['product_id' => $id]);
        $categorys = $categoryTable->findAll();

        $choice_category = [];
        foreach ($categorys as $category) {
            $choice_category[$category->getCategory_name()] = $category->getCategory_id();
        };

        // foreach carousel create input hidden with link img
        // xml upload img
        // post all img in database

        $form_update = $this
            ->createForm("", "post", ["enctype" => "multipart/form-data"])
            ->add("id", HiddenType::class, ['value' => $product->getId()])
            ->add("img[]", HiddenType::class)
            ->add("file[]", FileType::class, ['multiple' => "multiple"])
            ->add("name", TextType::class, ['value' => $product->getName()])
            ->add("description", TextareaType::class, ['value' => $product->getDescription()])
            ->add("price", TextType::class, ['value' => $product->getPrice()])
            ->add("categorie", ChoiceType::class, ['choices' => $choice_category, 'table' => $categoryTable])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();


        if ($form_update->isSubmit()) {
            $error = $form_update->isXmlValid($productsTable);
            if ($error->noError()) {
                $data = $form_update->getData();

                if (is_array($data['img'])) {
                    foreach ($data['img'] as $key => $value) {
                        $carouselTable
                            ->setProduct_id($id)
                            ->setImg($value)
                            ->setType($key + 1)
                            ->flush();
                    }
                } else {
                    $carouselTable
                        ->setProduct_id($id)
                        ->setImg($data['img'])
                        ->setType(1)
                        ->flush();
                }

                $product
                    ->setName($data["name"])
                    ->setDescription($data["description"])
                    ->setPrice($data["price"])
                    ->setCategory_id($data["categorie"])
                    ->flush();

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin", "success_location");
                $error->getXmlMessage($this->app->getProperties(Products::class));
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/update.php', '/admin.php', [
            'title' => 'Admin | Update | ' . $product->getName(),
            'carousel' => $carousel,
            'form_update' => $form_update,
        ]);
    }

    // insert image
    #[Route('/admin/insert', name: 'insert')]
    public function insert()
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }

        $productsTable = $this->app->getTable('Products');
        $categoryTable = $this->app->getTable('Category');

        $categorys = $categoryTable->findAll();

        $choice_category = [];
        foreach ($categorys as $category) {
            $choice_category[$category->getCategory_name()] = $category->getCategory_id();
        };

        $form_insert = $this
            ->createForm()
            ->add("name", TextType::class)
            ->add("description", TextareaType::class)
            ->add("price", TextType::class)
            ->add("categorie", ChoiceType::class, ['choices' => $choice_category, 'table' => $categoryTable])
            ->add("submit", SubmitType::class, ['value' => 'Insert'])
            ->getForm();

        if ($form_insert->isSubmit()) {
            $error = $form_insert->isXmlValid($productsTable);
            if ($error->noError()) {
                $data = $form_insert->getData();

                $productsTable
                    ->setName($data["name"])
                    ->setDescription($data["description"])
                    ->setPrice($data["price"])
                    ->setCategory_id($data["categorie"])
                    ->flush();

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin", "success_location");
                $error->getXmlMessage($this->app->getProperties(Products::class));
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/insert.php', '/admin.php', [
            'title' => 'Admin | Update | Insert',
            'form_insert' => $form_insert->createView(),
        ]);
    }

    #[Route('/get/image', name: 'image_html')]
    public function getImage()
    {
        echo URL . "/assets/img/";
    }

    #[Route('/get/upload-image', name: 'upload_image')]
    public function uploadImage()
    {
        $uploads_dir = ROOT . '\public\assets\img';
        if (isset($_FILES["file"])) {
            $tmp_name = $_FILES["file"]["tmp_name"];
            $name = basename($_FILES["file"]["name"]);
            move_uploaded_file($tmp_name, "$uploads_dir\\$name");
            echo $name;
        }
    }


    // show all category with update and delete
    // create category


    // show all users with update and delete
    // insert user

    // show orders

    // update settings
}
