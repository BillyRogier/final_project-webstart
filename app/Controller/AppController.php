<?php

namespace App\Controller;

use App\Table\Carousel;
use App\Table\Categorys;
use App\Table\Orders;
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

        $ProductsTable
            ->leftJoin(Orders::class)
            ->on("products.id = orders.product_id");

        $products = $ProductsTable->find("
        products.id, products.name, products.price, carousel.img, SUM(orders.quantity) AS total_quantity", "
        WHERE products.visibility = 1 AND carousel.type = 1
        GROUP BY products.id, products.name, products.price, carousel.img
        ORDER BY total_quantity DESC
        LIMIT 8;");

        return $this->render('/app/home.php', '/default.php',  [
            'title' => 'Accueil',
            'desc' => 'Découvrez une sélection exclusive d\'outils essentiels pour les amateurs et les professionnels de l\'espresso. Trouvez tout ce dont vous avez besoin pour préparer le café parfait, des machines haut de gamme aux accessoires indispensables. Profitez de notre expertise en SEO pour vous offrir une expérience d\'achat en ligne exceptionnelle. Commandez dès maintenant chez Espresso Tools et délectez-vous d\'une tasse d\'espresso exquis à chaque gorgée.',
            'products' => $products,
            'categorys' => $categorys,
        ]);
    }

    #[Route('/about')]
    public function about()
    {
        return $this->render('/app/about.php', '/default.php',  [
            'title' => 'À propos',
            'desc' => 'Chez Espresso Tools, nous sommes passionnés par l\'art de l\'espresso. Notre équipe d\'experts est dédiée à fournir les meilleurs outils et accessoires pour vous aider à préparer le café parfait. Que vous soyez un amateur passionné ou un barista professionnel, nous avons ce qu\'il vous faut. Notre engagement envers la qualité, l\'innovation et le service client exceptionnel nous distingue. Explorez notre gamme soigneusement sélectionnée de machines à espresso, de moulins à café, de tasses et bien plus encore. Rejoignez-nous dans notre quête pour une expérience caféine inoubliable. Bienvenue chez Espresso Tools !',
        ]);
    }

    #[Route('/sell-condition')]
    public function sellsConditions()
    {
        return $this->render('/app/sells_conditions.php', '/default.php',  [
            'title' => 'Condition générales de vente',
            'desc' => 'Découvrez nos conditions générales de ventes directement sur cette page ou contactez notre service client !',
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
            'desc' => ' Toutes les informations légales au sujet de Espresso Tools sont disponibles sur cette page. Mentions légales, données personnelles, cookies, sites frauduleux.',
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
            'form' => $form_builder->createView(),
            'desc' => 'N\'hésitez pas à nous contacter pour toute question, suggestion ou demande d\'assistance. Chez Espresso Tools, nous sommes là pour vous aider à trouver les solutions les plus adaptées à vos besoins en matière d\'espresso. ',
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

        $ProductsTable
            ->leftJoin(Orders::class)
            ->on("products.id = orders.product_id");

        $products_trends = $ProductsTable->find("
         products.id, products.name, products.price, carousel.img, SUM(orders.quantity) AS total_quantity", "
         WHERE products.visibility = 1 AND carousel.type = 1
         GROUP BY products.id, products.name, products.price, carousel.img
         ORDER BY total_quantity DESC
         LIMIT 8;");


        $ReviewsTable = new Reviews();
        $ReviewsTable
            ->leftJoin(Users::class)
            ->on("reviews.user_id = users.id");
        $reviews = $ReviewsTable->findAllBy(['reviews.product_id' => $id]);

        return $this->render('/app/product.php', '/default.php',  [
            'title' => 'Product',
            'desc' => $products[0]->getDescription(),
            'products' => $products,
            'products_trends' => $products_trends,
            'reviews' => $reviews,
            'form' => $form_builder->createView(),
        ]);
    }

    #[Route('/category/{category}')]
    public function category($category)
    {
        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Categorys::class)
            ->on("products.category_id = categorys.category_id")
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products =
            $category == "all-products" ?
            $ProductsTable->findAllBy(["carousel.type" => 1], "AND products.visibility != 2") :
            $ProductsTable->findAllBy(["carousel.type" => 1, "categorys.url" => $category], "AND products.visibility != 2");

        if (!$products) {
            $this->headLocation("/");
        }

        return $this->render('/app/category.php', '/default.php',  [
            'title' => str_replace("-", " ", ucfirst(($category != "all-products" ? $products[0]->getJoin(Categorys::class)->getCategory_name() : "Tous les produits"))),
            'desc' => 'Décrouvez tous les produits Espresso Tools dans la catégorie ' . str_replace("-", " ", ucfirst(($category != "all-products" ? $products[0]->getJoin(Categorys::class)->getCategory_name() : "Tous les produits"))),
            'subtitle' => strtolower($products[0]->getJoin(Categorys::class)->getCategory_name()),
            'category_img' => $products[0]->getJoin(Categorys::class)->getCategory_img(),
            'products' => $products,
        ]);
    }
}
