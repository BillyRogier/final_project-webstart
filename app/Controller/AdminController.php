<?php

namespace App\Controller;

use App;
use Core\Controller\AbstarctController;
use Core\Route\Route;

class AdminController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        return $this->render('/admin/index.php', '/admin.php', [
            'title' => 'Admin | Accueil',
        ]);
    }
}
