<?php

namespace Core\Controller;

use Core\Error\Error;
use Core\Form\Form;
use Core\Login\Login;
use Core\Response\Response;

abstract class AbstarctController
{
    protected $response;

    public function render($page, $templates, $array): Response
    {
        $response = new Response();
        $response->setPath($page);
        $response->setTemplates($templates);
        $response->setRenderArray($array);
        return $response;
    }

    public function createForm(string $action = "", string $method = "post", array $options = [])
    {
        $form = new Form();
        return $form->createForm($action, $method, $options);
    }

    public function getLogin()
    {
        return new Login('Users');
    }

    public function getError()
    {
        return new Error();
    }

    public function headLocation(string $url)
    {
        header("Location: " . URL . $url);
        exit;
    }

    public function isAdmin()
    {
        if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
            return false;
        }
        return true;
    }

    public function dump($val)
    {
        echo "<pre>";
        var_dump($val);
        echo "</pre>";
    }
}
