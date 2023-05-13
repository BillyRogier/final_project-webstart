<?php

namespace App\Controller;

use App;
use App\Table\Categorys;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class CategorysController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin/categorys')]
    public function showCategorys()
    {
        $CategorysTable = new Categorys();
        $categorys = $CategorysTable->findAll();

        $form_delete = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($CategorysTable);
            if ($error->noError()) {
                $data = $form_delete->getData();
                $category = $CategorysTable->findOneBy(['category_id' => $data['id']]);

                if ($category) {
                    $ProductsTable = new Products();
                    $products = $ProductsTable->findAllBy(['category_id' => $data['id']]);

                    foreach ($products as $product) {
                        $product
                            ->setCategory_id(null)
                            ->flush();
                    }

                    if (file_exists(UPLOAD_DIR . $category->getCategory_img())) {
                        unlink(UPLOAD_DIR . $category->getCategory_img());
                    }

                    $CategorysTable->delete(['category_id' => $data['id']]);

                    $_SESSION["message"] = $error->success("delete successfully");
                    $error->location(URL . "/admin/categorys", "success_location");
                } else {
                    $error->danger("error occured", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Categorys::class));
        }

        return $this->render('/admin/categorys.php', '/admin.php', [
            'title' => 'Admin | Categorys',
            'categorys' => $categorys,
            'form_delete' => $form_delete
        ]);
    }

    #[Route('/admin/categorys/insert')]
    public function insertCategory()
    {
        $formBuilder = $this->createForm()
            ->add("name", TextType::class, ['label' => 'Name', 'id' => 'name'])
            ->add("img", HiddenType::class)
            ->add("file", FileType::class, ['label' => 'Choose a file', 'id' => 'file', 'class' => 'file'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $CategorysTable = new Categorys();
            $error = $formBuilder->isXmlValid($CategorysTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    $tmp_name = $data["file"]["tmp_name"];
                    $temp = explode(".", $_FILES["file"]["name"]);
                    $name = round(microtime(true)) . '.' . end($temp);
                    if (!file_exists(UPLOAD_DIR . $name)) {
                        move_uploaded_file($tmp_name, UPLOAD_DIR . $name);
                    }

                    $CategorysTable
                        ->setCategory_name($data['name'])
                        ->setCategory_img($name)
                        ->setAlt($data['alt'])
                        ->flush();

                    $_SESSION["message"] = $error->success("successfully insert");
                    $error->location(URL . "/admin/categorys", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Categorys::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Categorys | Insert',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin/categorys/update/{id}')]
    public function updateCategory(int $id)
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
