<?php

namespace App\Controller;

use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Settings;
use App\Table\Users;
use Core\Cart\Cart;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\NumberType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Route\Route;
use PHPMailer\PHPMailer\PHPMailer;

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

    #[Route('/about')]
    public function about()
    {
        return $this->render('/app/about.php', '/default.php',  [
            'title' => 'À propos',
        ]);
    }

    #[Route('/mentions-legales')]
    public function mentionsLegales()
    {
        $SettingsTable = new Settings();
        $settings = $SettingsTable->findOne();

        return $this->render('/app/mentions_legales.php', '/default.php',  [
            'title' => 'Mentions Légales',
            'settings' => $settings,
        ]);
    }

    #[Route('/contact')]
    public function contact()
    {
        $SettingsTable = new Settings();
        $settings = $SettingsTable->findOne();

        $form_builder = $this->createForm("", 'post', ['class' => 'grid'])
            ->add("name", TextType::class, ['label' => 'Nom', 'id' => 'name'])
            ->add("email", EmailType::class, ['label' => 'email', 'id' => 'email'])
            ->add("message", TextareaType::class, ['label' => 'message', 'id' => 'message'])
            ->add("submit", SubmitType::class, ['value' => 'Envoyé', 'class' => 'btn']);

        if ($form_builder->isSubmit()) {
            $error = $form_builder->isXmlValid();
            if ($error->noError()) {
                $data = $form_builder->getData();

                if (!empty($settings->getServer()) || !empty($settings->getPort()) || !empty($settings->getEmail()) || !empty($settings->getEmail_pass())) {
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->Host = $settings->getServer();
                    $mail->Port = $settings->getPort();
                    $mail->SMTPAuth = true;
                    $mail->CharSet = "UTF-8";
                    $mail->Username = $settings->getEmail();
                    $mail->Password = $settings->getEmail_pass();
                    $mail->SMTPSecure = $settings->getEmail_security();
                    $mail->setFrom($data['email'], $data['name']);
                    $mail->addReplyTo($data['email'], $data['name']);
                    $mail->addAddress($settings->getEmail(), ($settings->getFirst_name() . " " . $settings->getLast_name()));
                    $mail->Subject = 'Message envoyé via le site internet';
                    $mail->msgHTML(file_get_contents('message.html'), __DIR__);
                    $mail->Body = $data["message"];
                    if (!$mail->send()) {
                        $_SESSION["message"] = $error->danger("Une erreur est survenue", 'error_container');
                    } else {
                        $_SESSION["message"] = $error->success("Email envoyé avec succès");
                        $error->location(URL . "/contact", "success_location");
                    }
                } else {
                    $_SESSION["message"] = $error->danger("Une erreur est survenue", 'error_container');
                }
            }
            $error->getXmlMessage("");
        }

        return $this->render('/app/contact.php', '/default.php',  [
            'title' => 'Contact',
            'settings' => $settings,
            'form' => $form_builder->createView()
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

        $form_builder = $this->createForm("", "post", ['class' => 'add_to_cart grid'])
            ->add("quantity", NumberType::class, ['id' => 'quantity', 'class' => 'quantity', 'value' => '1'])
            ->add("submit", SubmitType::class, ['value' => 'Ajouter au panier', 'class' => 'btn'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            $error = $form_builder->isXmlValid($ProductsTable);
            if ($error->noError()) {
                $data = $form_builder->getData();

                $Cart = new Cart();
                $Cart->addToCart($id, $data['quantity']);


                $_SESSION["message"] = $error->success("Le produit a bien été ajouté au panier");
                $error->location(URL . "/product/$id", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Products::class));
        }

        $products_trends = $ProductsTable->findAllBy(["carousel.type" => 1], "AND products.visibility != 2 OR carousel.type IS NULL");

        $ReviewsTable = new Reviews();
        $ReviewsTable
            ->leftJoin(Users::class)
            ->on("reviews.user_id = users.id");
        $reviews = $ReviewsTable->findAllBy(['reviews.product_id' => $id]);

        return $this->render('/app/product.php', '/default.php',  [
            'title' => 'Product',
            'products' => $products,
            'products_trends' => $products_trends,
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

        if (!$products) {
            $this->headLocation("/");
        }

        return $this->render('/app/category.php', '/default.php',  [
            'title' => str_replace("-", " ", ucfirst(($category != "all-products" ? $category : "Tous les produits"))),
            'subtitle' => $category,
            'category_img' => $products[0]->getCategory_img(),
            'products' => $products,
        ]);
    }
}
