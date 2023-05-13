<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class ProductsController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
    }

    #[Route('/admin/products')]
    public function showProducts()
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
                $carousels = $ProductsTable->getJoin(Carousel::class)->findAllBy(['product_id' => $data['id']]);

                foreach ($carousels as $carousel) {
                    if (file_exists(UPLOAD_DIR . $carousel->getImg())) {
                        unlink(UPLOAD_DIR . $carousel->getImg());
                    }
                }

                $ProductsTable->getJoin(Carousel::class)->delete(['product_id' => $data['id']]);
                $ProductsTable->delete(['id' => $data['id']]);

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin/products", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/products.php', '/admin.php', [
            'title' => 'Admin | Products',
            'products' => $products,
            'form_delete' => $form_delete
        ]);
    }

    #[Route('/admin/products/insert')]
    public function insertProduct()
    {
        $CategorysTable = new Categorys();
        $categorys = $CategorysTable->findAll();

        $category_choices = [];
        foreach ($categorys as $category) {
            $category_choices[$category->getCategory_name()] = $category->getCategory_id();
        }

        $formBuilder = $this->createForm()
            ->add("name", TextType::class, ['label' => 'Name', 'id' => 'name'])
            ->add("description", TextType::class, ['label' => 'Description', 'id' => 'description'])
            ->add("price", TextType::class, ['label' => 'Price', 'id' => 'price'])
            ->add("img[]", HiddenType::class)
            ->add("file[]", FileType::class, ['label' => 'Choose a file', 'id' => 'file', 'class' => 'file', 'multiple' => true])
            ->add("category", ChoiceType::class, ['label' => 'Category', 'choices' => $category_choices, 'id' => 'category'])
            ->add("visibility", ChoiceType::class, ['label' => 'Visibility', 'choices' => ['visible' => 1, 'hidden' => 0, 'no stock' => 2], 'id' => 'visibility'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $ProductsTable = new Products();
            $error = $formBuilder->isXmlValid($ProductsTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                var_dump($data);
                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    if (empty($_POST['visibility']) || !in_array($_POST['visibility'], [0, 1, 2]) || empty($_POST['category']) || !$CategorysTable->findOneBy(['category_id' => $_POST['category']])) {
                        $error->danger("error occured", "error_container");
                    } else {
                        $ProductsTable
                            ->setName($data["name"])
                            ->setDescription($data["description"])
                            ->setPrice($data["price"])
                            ->setCategory_id($data["category"])
                            ->setVisibility($data['visibility'])
                            ->flush();

                        $CarouselsTable = new Carousel();

                        for ($i = 0; $i < count($data["file"]["tmp_name"]); $i++) {
                            $tmp_name = $data["file"]["tmp_name"][$i];
                            $temp = explode(".", $_FILES["file"]["name"][$i]);
                            $name = round(microtime(true)) . '.' . end($temp);

                            if (!file_exists(UPLOAD_DIR . $name)) {
                                move_uploaded_file($tmp_name, UPLOAD_DIR . $name);
                            }

                            $CarouselsTable
                                ->setImg($name)
                                ->setAlt($data['alt'][$i])
                                ->setProduct_id($ProductsTable->lastInsertId())
                                ->flush();
                        }
                        $_SESSION["message"] = $error->success("successfully insert");
                        $error->location(URL . "/admin/categorys", "success_location");
                    }
                }
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Products | Insert',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin/products/update/{id}')]
    public function updateProduct(int $id)
    {
        $CategorysTable = new Categorys();
        $category = $CategorysTable->findOneBy(["category_id" => $id]);

        if (!$category) {
            $this->headLocation("/admin/categorys");
        }

        $formBuilder = $this->createForm()
            ->add("name", TextType::class, ['value' => $category->getCategory_name(), 'label' => 'Name', 'id' => 'name'])
            ->add("img", HiddenType::class, [
                'value' => $category->getCategory_img(),
                'html' =>
                '<img src="' . URL . '/assets/img/' . $category->getCategory_img() . '" alt="' . $category->getAlt() . '">
                <input name="alt" type="text" placeholder="Description image" class="img_alt" value="' . $category->getAlt() . '">
                <span class="del_image btn">delete</span>'
            ])
            ->add("file", FileType::class, ['label' => 'Choose a file', 'id' => 'file', 'class' => 'file'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($CategorysTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    if (!empty($data["file"]["tmp_name"])) {
                        $tmp_name = $data["file"]["tmp_name"];
                        $temp = explode(".", $_FILES["file"]["name"]);
                        $name = round(microtime(true)) . '.' . end($temp);
                        if (!file_exists(UPLOAD_DIR . $name)) {
                            move_uploaded_file($tmp_name, UPLOAD_DIR . $name);
                        }

                        if (file_exists(UPLOAD_DIR . $category->getCategory_img())) {
                            unlink(UPLOAD_DIR . $category->getCategory_img());
                        }

                        $category
                            ->setCategory_img($name);
                    }

                    $category
                        ->setCategory_name($data['name'])
                        ->setAlt($data['alt'])
                        ->flush();

                    $_SESSION["message"] = $error->success("successfully update");
                    $error->location(URL . "/admin/categorys", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Categorys::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Categorys | Update',
            'form' => $formBuilder->createView(),
        ]);
    }
}
