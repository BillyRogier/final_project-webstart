<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Orders;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class ProductsController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
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

        $products = $ProductsTable->findAll();

        $form_delete = $this
            ->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'supprimer', 'class' => 'btn del'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($ProductsTable);
            if ($error->noError()) {
                $data = $form_delete->getData();
                $carousels = $ProductsTable->getJoin(Carousel::class)->findAllBy(['product_id' => $data['id']]);

                $OrdersTable = new Orders();
                if (!$OrdersTable->findOneBy(['product_id' => $data['id']])) {
                    foreach ($carousels as $carousel) {
                        if (file_exists(UPLOAD_DIR . $carousel->getImg())) {
                            unlink(UPLOAD_DIR . $carousel->getImg());
                        }
                    }
                    $ProductsTable->getJoin(Carousel::class)->delete(['product_id' => $data['id']]);
                    $ProductsTable->delete(['id' => $data['id']]);

                    $_SESSION["message"] = $error->success("Supprimer avec succès");
                } else {
                    $product = $ProductsTable->findOneBy(['id' => $data['id']]);
                    $product->setVisibility(2)->flush();

                    $_SESSION["message"] = $error->success("Produit avec commandes donc passé en invisible");
                }

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

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("name", TextType::class, ['label' => 'Name', 'id' => 'name'])
            ->add("description", TextType::class, ['label' => 'Description', 'id' => 'description'])
            ->add("price", NumberType::class, ['label' => 'Price', 'id' => 'price'])
            ->add("img[]", HiddenType::class)
            ->add("file[]", FileType::class, ['label' => 'Choose a file', 'id' => 'file', 'class' => 'file', 'multiple' => true])
            ->add("category", ChoiceType::class, ['label' => 'Category', 'choices' => $category_choices, 'id' => 'category'])
            ->add("visibility", ChoiceType::class, ['label' => 'Visibility', 'choices' => ['visible' => 1, 'hidden' => 2, 'no stock' => 3], 'id' => 'visibility'])
            ->add("submit", SubmitType::class, ['value' => 'Enregistrer', 'class' => 'btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $ProductsTable = new Products();
            $error = $formBuilder->isXmlValid($ProductsTable);
            if (isset($_POST['alt'])) {
                foreach ($_POST['alt'] as $alt) {
                    if (empty($alt)) {
                        $error->danger("veuillez remplir le champs description image", "alt");
                    }
                }
            }
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if (empty($_POST['visibility']) || !isset($_POST['alt']) || !in_array($_POST['visibility'], [1, 2, 3]) || empty($_POST['category']) || !$CategorysTable->findOneBy(['category_id' => $_POST['category']])) {
                    $error->danger("Une erreur est survenue", "error_container");
                } else {
                    $ProductsTable
                        ->setName($data["name"])
                        ->setDescription($data["description"])
                        ->setPrice($data["price"])
                        ->setCategory_id($data["category"])
                        ->setVisibility($data['visibility'])
                        ->flush();

                    $product_id = $ProductsTable->lastInsertId();

                    $CarouselsTable = new Carousel();

                    for ($i = 0; $i < count($data["file"]["tmp_name"]); $i++) {
                        $tmp_name = $data["file"]["tmp_name"][$i];
                        $temp = explode(".", $_FILES["file"]["name"][$i]);
                        $name = bin2hex(random_bytes(16)) . '.' . end($temp);

                        if (!file_exists(UPLOAD_DIR . $name)) {
                            move_uploaded_file($tmp_name, UPLOAD_DIR . $name);
                        }

                        $CarouselsTable
                            ->setImg($name)
                            ->setAlt($data['alt'][$i])
                            ->setProduct_id($product_id)
                            ->setType($i + 1)
                            ->flush();
                    }

                    $_SESSION["message"] = $error->success("Inséré avec succès");
                    $error->location(URL . "/admin/products", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/formulaire.php', '/admin.php', [
            'title' => 'Admin | Products | Insert',
            'title_page' => 'Insérer produit',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin/products/update/{id}')]
    public function updateProduct(int $id)
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Categorys::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $product = $ProductsTable->findAllBy(["products.id" => $id]);

        if (!$product) {
            $this->headLocation("/admin/products");
        }

        $CategorysTable = $ProductsTable->getJoin(Categorys::class);
        $categorys = $CategorysTable->findAll();

        $category_choices = [];
        foreach ($categorys as $category) {
            $category_choices[$category->getCategory_name()] = $category->getCategory_id();
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("name", TextType::class, ['label' => 'Name', 'id' => 'name', 'value' => $product[0]->getName()])
            ->add("description", TextType::class, ['label' => 'Description', 'id' => 'description', 'value' => $product[0]->getDescription()])
            ->add("price", NumberType::class, ['label' => 'Price', 'id' => 'price', 'value' => $product[0]->getPrice()]);

        foreach ($product as $prdt) {
            $formBuilder
                ->add("img[]", HiddenType::class, [
                    'value' => $prdt->getJoin(Carousel::class)->getImg(),
                    'html' =>
                    '<img src="' . BASE_PUBLIC . '/assets/img/' . $prdt->getJoin(Carousel::class)->getImg() . '" alt="' . $prdt->getJoin(Carousel::class)->getAlt() . '">
                <input name="alt[]" type="text" placeholder="Description image" class="img_alt" value="' . $prdt->getJoin(Carousel::class)->getAlt() . '">
                <span class="del_image btn">delete</span>'
                ]);
        }
        $formBuilder
            ->add("file[]", FileType::class, ['label' => 'Choose a file', 'id' => 'file', 'class' => 'file', 'multiple' => true])
            ->add("category", ChoiceType::class, ['label' => 'Category', 'choices' => $category_choices, 'value' => $product[0]->getCategory_id(), 'id' => 'category'])
            ->add("visibility", ChoiceType::class, ['label' => 'Visibility', 'choices' => ['visible' => 1, 'hidden' => 2, 'no stock' => 3], 'value' => $product[0]->getVisibility(), 'id' => 'visibility'])
            ->add("submit", SubmitType::class, ['value' => 'Enregistrer', 'class' => 'btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ProductsTable);
            if (isset($_POST['alt'])) {
                foreach ($_POST['alt'] as $alt) {
                    if (empty($alt)) {
                        $error->danger("veuillez remplir le champs description image", "alt");
                    }
                }
            }
            if ($error->noError()) {
                if (empty($_POST['visibility']) || !isset($_POST['alt']) || !in_array($_POST['visibility'], [1, 2, 3]) || empty($_POST['category']) || !$CategorysTable->findOneBy(['category_id' => $_POST['category']])) {
                    $error->danger("error occured", "error_container");
                } else {
                    $data = $formBuilder->getData();

                    foreach ($product as $prdt) {
                        if (!in_array($prdt->getJoin(Carousel::class)->getImg(), $data['img'])) {
                            if (file_exists(UPLOAD_DIR . $prdt->getJoin(Carousel::class)->getImg())) {
                                unlink(UPLOAD_DIR . $prdt->getJoin(Carousel::class)->getImg());
                            }
                            $prdt->getJoin(Carousel::class)->delete(['img' => $prdt->getJoin(Carousel::class)->getImg()]);
                        }
                    }

                    $f = 0;
                    for ($i = 0; $i < count($data["img"]); $i++) {
                        $carousel_img = $ProductsTable->getJoin(Carousel::class)->findOneBy(["img" => $data["img"][$i]]);
                        if ($carousel_img) {
                            $carousel_img
                                ->setAlt($data['alt'][$i])
                                ->setProduct_id($id)
                                ->setType($i + 1)
                                ->flush();
                        } else {
                            $tmp_name = $data["file"]["tmp_name"][$f];
                            $temp = explode(".", $_FILES["file"]["name"][$f]);
                            $name = uniqid() . '.' . end($temp);

                            if (!file_exists(UPLOAD_DIR . $name)) {
                                move_uploaded_file($tmp_name, UPLOAD_DIR . $name);
                            }

                            $ProductsTable->getJoin(Carousel::class)
                                ->setImg($name)
                                ->setAlt($data['alt'][$i])
                                ->setProduct_id($id)
                                ->setType($i + 1)
                                ->flush();

                            $f += 1;
                        }
                    }

                    $product[0]
                        ->setName($data['name'])
                        ->setDescription($data['description'])
                        ->setPrice($data['price'])
                        ->setCategory_id($data['category'])
                        ->setVisibility($data['visibility'])
                        ->flush();

                    $_SESSION["message"] = $error->success("Modifications enregistrées");
                    $error->location(URL . "/admin/products", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Categorys::class));
        }

        return $this->render('/admin/formulaire.php', '/admin.php', [
            'title' => 'Admin | Products | Update',
            'title_page' => 'Modifier produit',
            'form' => $formBuilder->createView(),
        ]);
    }
}
