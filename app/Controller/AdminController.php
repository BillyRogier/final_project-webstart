<?php

namespace App\Controller;

use App;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
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

                if ($_SESSION['message'] == "") {
                    exit;
                }
            }
            return $_SESSION['message'];
        }

        return $this->render('/pages/admin/login.php', '', [
            'title' => 'admin | login',
            'form' => $formBuilder->createView(),
        ]);
    }
}
