<?php

namespace App\Controller;

use App;
use App\Table\Category;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\EmailType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\PasswordType;
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

    #[Route('/login', name: 'login')]
    public function login()
    {
        if ($this->isAdmin()) {
            $this->headLocation("/admin");
        }

        $formBuilder = $this
            ->createForm()
            ->add("email", EmailType::class)
            ->add("password", PasswordType::class)
            ->add("submit", SubmitType::class, ['value' => 'login'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            if ($formBuilder->isValid('Users')) {
                $data = $formBuilder->getData();

                $this->getLogin()
                    ->verify($data['email'], $data['password']);

                $this->headLocation("/admin");
            }
        }

        return $this->render('/login.php', '/login.php', [
            'title' => 'admin | login',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register()
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }

        $formBuilder = $this
            ->createForm()
            ->add("email", EmailType::class)
            ->add("password", PasswordType::class)
            ->add("submit", SubmitType::class, ['value' => 'register'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            if ($formBuilder->isValid('Users')) {
                $data = $formBuilder->getData();

                $this->getLogin()
                    ->register($data['email'], $data['password']);

                if ($_SESSION['message'] == "") {
                    exit;
                }
            }
            return $_SESSION['message'];
        }

        return $this->render('/login.php', '/login.php', [
            'title' => 'admin | login',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }

        $productsTable = $this->app->getTable('Products');
        $productsTable
            ->join(Category::class)
            ->on("products.category_id = category.category_id");

        $products = $productsTable->findAll();

        $form_delete = $this
            ->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class)
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($productsTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                $productsTable->delete($data['id']);

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
        $categoryTable = $this->app->getTable('Category');

        $productsTable
            ->join(Category::class)
            ->on("products.category_id = category.category_id");

        $product = $productsTable->findOneBy(['products.id' => $id]);
        $categorys = $categoryTable->findAll();

        $choice_category = [];
        foreach ($categorys as $category) {
            $choice_category[$category->getCategory_name()] = $category->getCategory_id();
        };

        $form_update = $this
            ->createForm()
            ->add("id", HiddenType::class, ['value' => $product->getId()])
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
            'form_update' => $form_update->createView(),
        ]);
    }

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
}
