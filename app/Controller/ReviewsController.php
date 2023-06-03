<?php

namespace App\Controller;

use App;
use App\Table\Products;
use App\Table\Reviews;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Route\Route;

class ReviewsController extends AbstarctController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin/reviews')]
    public function showReviews()
    {
        $ReviewsTable = new Reviews();
        $ReviewsTable
            ->innerJoin(Users::class)
            ->on("reviews.user_id = users.id")
            ->innerJoin(Products::class)
            ->on("reviews.product_id = products.id");
        $reviews = $ReviewsTable->findAll();

        $form_delete = $this
            ->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'supprimer'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($ReviewsTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                if ($ReviewsTable->findOneBy(['reviews.review_id' => $data['id']])) {
                    $ReviewsTable->delete(['reviews.review_id' => $data['id']]);

                    $_SESSION["message"] = $error->success("successfully delete");
                    $error->location(URL . "/admin/reviews", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Reviews::class));
        }

        return $this->render('/admin/reviews.php', '/admin.php', [
            'title' => 'Admin | Reviews',
            'reviews' => $reviews,
            'form_delete' => $form_delete
        ]);
    }

    #[Route('/admin/reviews/insert')]
    public function insertReview()
    {
        $ReviewsTable = new Reviews();
        $ReviewsTable
            ->innerJoin(Users::class)
            ->on("reviews.user_id = users.id")
            ->innerJoin(Products::class)
            ->on("reviews.product_id = products.id");

        $users = $ReviewsTable->getJoin(Users::class)->findAll();

        $users_choices = [];
        foreach ($users as $user) {
            $users_choices[$user->getEmail()] = $user->getId();
        }

        $products = $ReviewsTable->getJoin(Products::class)->findAll();

        $products_choices = [];
        foreach ($products as $product) {
            $products_choices[$product->getName()] = $product->getId();
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("user", ChoiceType::class, ['label' => 'Users', 'id' => 'user', 'choices' => $users_choices])
            ->add("product", ChoiceType::class, ['label' => 'Product', 'id' => 'product', 'choices' => $products_choices])
            ->add("description", TextareaType::class, ['label' => 'Description', 'id' => 'description'])
            ->add("grade", NumberType::class, ['label' => 'Grade', 'id' => 'grade'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ReviewsTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                $ReviewsTable
                    ->setUser_id($data['user'])
                    ->setProduct_id($data['product'])
                    ->setDescription($data['description'])
                    ->setGrade($data['grade'])
                    ->flush();

                $_SESSION["message"] = $error->success("successfully insert");
                $error->location(URL . "/admin/reviews", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Reviews::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Reviews | Insert',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin/reviews/update/{id}')]
    public function updateReview(int $id)
    {
        $ReviewsTable = new Reviews();
        $ReviewsTable
            ->innerJoin(Users::class)
            ->on("reviews.user_id = users.id")
            ->innerJoin(Products::class)
            ->on("reviews.product_id = products.id");

        $review = $ReviewsTable->findOneBy(["reviews.review_id" => $id]);

        if (!$review) {
            $this->headLocation("/admin/reviews");
        }

        $users = $ReviewsTable->getJoin(Users::class)->findAll();

        $users_choices = [];
        foreach ($users as $user) {
            $users_choices[$user->getEmail()] = $user->getId();
        }

        $products = $ReviewsTable->getJoin(Products::class)->findAll();

        $products_choices = [];
        foreach ($products as $product) {
            $products_choices[$product->getName()] = $product->getId();
        }

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("user", ChoiceType::class, ['label' => 'Users', 'value' => $review->getUser_id(), 'id' => 'user', 'choices' => $users_choices])
            ->add("product", ChoiceType::class, ['label' => 'Product', 'value' => $review->getProduct_id(), 'id' => 'product', 'choices' => $products_choices])
            ->add("description", TextareaType::class, ['label' => 'Description', 'value' => $review->getDescription(), 'id' => 'description'])
            ->add("grade", NumberType::class, ['label' => 'Grade', 'value' => $review->getGrade(), 'id' => 'grade'])
            ->add("submit", SubmitType::class, ['value' => 'Save'])
            ->getForm();


        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ReviewsTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                if (!$ReviewsTable->getJoin(Users::class)->findOneBy(['users.id' => $data['user']])) {
                    $error->danger("error occured", "error_container");
                } else if (!$ReviewsTable->getJoin(Products::class)->findOneBy(['products.id' => $data['product']])) {
                    $error->danger("error occured", "error_container");
                } else {
                    $review
                        ->setUser_id($data['user'])
                        ->setProduct_id($data['product'])
                        ->setDescription($data['description'])
                        ->setGrade($data['grade'])
                        ->flush();

                    $_SESSION["message"] = $error->success("successfully update");
                    $error->location(URL . "/admin/reviews", "success_location");
                }
            }

            $error->getXmlMessage($this->app->getProperties(Reviews::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Products | Update',
            'form' => $formBuilder->createView(),
        ]);
    }
}
