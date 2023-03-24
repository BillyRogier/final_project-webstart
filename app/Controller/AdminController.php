<?php

namespace App\Controller;

use App;
use App\Table\Category;
use App\Table\Products;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
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
        $productsTable
            ->join(Category::class)
            ->on("products.category_id = category.category_id");

        $product = $productsTable->findOneBy(['products.id' => $id]);

        $form_update = $this
            ->createForm()
            ->add("id", HiddenType::class, ['value' => $product->getId()])
            ->add("name", TextType::class, ['value' => $product->getName()])
            ->add("description", TextareaType::class, ['value' => $product->getDescription()])
            ->add("price", TextType::class, ['value' => $product->getPrice()])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($form_update->isSubmit()) {
            $error = $form_update->isXmlValid('Products');
            if (empty($error->getErrorMessage())) {
                $data = $form_update->getData();

                $error->success("success", "error_container");
                $error->getXmlMessage($this->app->getProperties(Products::class));
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        return $this->render('/admin/update.php', '/admin.php', [
            'title' => 'Admin | Update | ' . $product->getName(),
            'form_update' => $form_update->createView(),
        ]);
    }
}
