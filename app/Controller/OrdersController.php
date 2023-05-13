<?php

namespace App\Controller;

use App;
use Core\Controller\AbstarctController;

class OrdersController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
    }
}
