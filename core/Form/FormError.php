<?php

namespace Core\Form;

use App;
use Core\Error\Error;
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

    public function getTableError()
    {
        $error = new Error();
        $properties = $this->app->getProperties($this->table::class);

        foreach ($this->form['input'] as $input => $value) {
            $inputType = $value['type'];
            if ($input == "id") {
                if (!isset($_POST['id']) || !$this->table->findOneBy(['id' => $_POST['id']])) {
                    $error->danger("error occured", $input);
                    return false;
                }
            } else if (!isset($_POST[$input]) || empty($_POST[$input])) {
                if ($inputType == SubmitType::class) {
                    continue;
                }
                $error->danger("veuillez remplir le champs $input", $input);
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

        if ($_SESSION['message'] != "") {
            return false;
        }
        return true;
    }

    public function getError(): bool
    {
        $error = new Error();

        foreach ($this->form['input'] as $input => $value) {
            $inputType = $value['type'];
            if (!isset($_POST[$input])) {
                if ($inputType == SubmitType::class) {
                    continue;
                }
                $error->danger("error occured", $input);
            } else if (empty($_POST[$input])) {
                if ($inputType == SubmitType::class) {
                    continue;
                }
                $error->danger("Veuillez remplir le $input", $input);
            } else {
                $classType = new $inputType();
                if (!$classType->isValid($_POST[$input])) {
                    $error->danger($classType->getMessage(), $input);
                }
            }
        }

        if (!empty($error->getErrorMessage())) {
            echo $error->getView();
            $error->setError("");
            exit;
        }
        return true;
    }
}
