<?php

namespace App\Controller;

use App\Table\Carousel;
use App\Table\Orders;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class AccountController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->app->isAdmin() && !$this->app->isUser()) {
            $this->headLocation("/");
        }
    }

    #[Route('/account')]
    public function account()
    {
        $OrdersTable = new Orders();
        $OrdersTable
            ->innerJoin(Users::class)
            ->on("users.id = orders.user_id")
            ->innerJoin(Products::class)
            ->on("products.id = orders.product_id")
            ->innerJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $orders = $OrdersTable->findAllBy(['users.id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']), 'carousel.type' => 1], "ORDER BY order_date DESC");

        $ProductsTable = new Products();
        $ProductsTable
            ->leftJoin(Carousel::class)
            ->on("carousel.product_id = products.id");

        $products_trends = $ProductsTable->findAllBy(["carousel.type" => 1], "AND products.visibility != 2 OR carousel.type IS NULL");

        return $this->render('/app/account_orders.php', '/default.php', [
            'title' => 'Account | Orders',
            'products_trends' => $products_trends,
            'orders' => $orders,
        ]);
    }

    #[Route('/account/settings')]
    public function settings()
    {
        $UsersTable = new Users();
        $user = $UsersTable->findOneBy(['users.id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin'])]);

        if (!$user) {
            $this->headLocation("/account");
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("last_name", TextType::class, ['value' => $user->getLast_name(), 'data-req' => true, 'label' => 'Nom', 'id' => 'last_name'])
            ->add("first_name", TextType::class, ['value' => $user->getFirst_name(), 'data-req' => true, 'label' => 'Prénom', 'id' => 'first_name'])
            ->add("email", EmailType::class, ['value' => $user->getEmail(), 'label' => 'Email', 'id' => 'email'])
            ->add("password", PasswordType::class, ['label' => 'New password', 'data-req' => true, 'id' => 'password'])
            ->add("num", TextType::class, ['value' => $user->getNum(), 'data-req' => true, 'label' => 'Numéro de téléphone', 'id' => 'num'])
            ->add("adress", TextType::class, ['value' => $user->getAdress(), 'data-req' => true, 'label' => 'Adresse', 'id' => 'adress'])
            ->add("submit", SubmitType::class, ['value' => 'Enregistrer', 'class' => 'btn'])
            ->getForm();


        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if ($data['password'] != "") {
                    $user
                        ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
                }

                $user
                    ->setFirst_name($data['first_name'])
                    ->setLast_name($data['last_name'])
                    ->setEmail($data['email'])
                    ->setNum($data['num'])
                    ->setAdress($data['adress'])
                    ->flush();

                $_SESSION["message"] = $error->success("successfully update");
                $error->location(URL . "/account/settings", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/account_settings.php', '/default.php', [
            'title' => 'Account | Settings',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/add-comment/{order_num}/{id}')]
    public function addComment($order_num, $id)
    {
        $OrdersTable = new Orders();
        if (!$OrdersTable->findOneBy(['order_num' => $order_num, 'user_id' => (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']), 'product_id' => $id])) {
            $this->headLocation("/account");
        }
        $ReviewsTable = new Reviews();

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("grade", HiddenType::class, [
                'label' => 'Note', 'id' => 'grade',
                'html' => '
                <div class="grade add_grade">
                    <div class="grade_ball"></div>
                    <div class="grade_ball"></div>
                    <div class="grade_ball"></div>
                    <div class="grade_ball"></div>
                    <div class="grade_ball"></div>
                </div>'
            ])
            ->add("title", TextType::class, ['label' => 'Titre', 'id' => 'title'])
            ->add("description", TextareaType::class, ['label' => 'Description', 'id' => 'description'])
            ->add("img", HiddenType::class, ['data-req' => true])
            ->add("file", FileType::class, ['label' => 'Ajouter un fichier', 'id' => 'file', 'class' => 'file', 'data-req' => true])
            ->add("submit", SubmitType::class, ['value' => 'Ajouter le commentaire', 'class' => 'btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ReviewsTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if ($data["file"]["tmp_name"]) {
                    $tmp_name = $data["file"]["tmp_name"];
                    $temp = explode(".", $_FILES["file"]["name"]);
                    $name = bin2hex(random_bytes(16)) . '.' . end($temp);

                    move_uploaded_file($tmp_name, UPLOAD_DIR . $name);

                    $ReviewsTable
                        ->setReview_img($name);
                }

                $ReviewsTable
                    ->setUser_id((isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']))
                    ->setProduct_id($id)
                    ->setReview_title($data['title'])
                    ->setDescription($data['description'])
                    ->setGrade($data['grade'])
                    ->flush();

                $_SESSION["message"] = $error->success("Le commentaire a bien été ajouté");
                $error->location(URL . "/account", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Reviews::class));
        }

        return $this->render('/app/add_comment.php', '/default.php', [
            'title' => 'Add comment',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/logout', name: 'admin')]
    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        $this->headLocation("/");
    }
}
