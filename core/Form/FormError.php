<?php

namespace Core\Form;

use App;
use App\Table\Products;
use Core\Error\Error;
use Core\Error\ErrorJson;
use Core\Form\Type\SubmitType;

class FormError extends Form implements FormErrorInterface
{
    private $table;
    private $app;
    protected $form;

    public function __construct($form, $table)
    {
        $this->app = App::getInstance();
        if (!empty($table)) {
            $this->table = $this->app->getTable($table);
        }
        $this->form = $form;
    }

    private function returnError($error)
    {
        return $error;
    }

    public function getError($xml)
    {
        if ($xml === true) {
            $error = new ErrorJson();
        } else {
            $error = new Error();
        }

        if (!empty($this->table)) {
            $properties = $this->app->getProperties($this->table::class);
        }

        foreach ($this->form['input'] as $input => $value) {
            $inputType = $value['type'];
            if (!isset($_POST[$input])) {
                if ($inputType == SubmitType::class) {
                    continue;
                }
                $error->danger("error occured", "error_container");
            }
            if (empty($_POST[$input])) {
                if ($inputType == SubmitType::class) {
                    continue;
                }
                $error->danger("veuillez remplir le champs $input", $input);
            } else if (!empty($this->table)) {
                if ($input == "id") {
                    if (!isset($_POST['id']) || !$this->table->findOneBy(['id' => $_POST['id']])) {
                        $error->danger("error occured", "error_container");
                    }
                } else {
                    $classType = new $inputType();
                    if (!$classType->isValid($_POST[$input])) {
                        $error->danger("le champs $input doit être de type " . $properties[$input]->getType() . "", $input);
                    }
                    if (isset($properties[$input]) && !empty($properties[$input]->getLenght())) {
                        if (strlen($_POST[$input]) > $properties[$input]->getLenght()) {
                            $error->danger("le champs $input doit contenir maximum " . $properties[$input]->getLenght() . "", $input);
                        }
                    }
                }
            }
        }

        return $this->returnError($error);
    }
}
