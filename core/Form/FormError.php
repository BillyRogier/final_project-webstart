<?php

namespace Core\Form;

use App;
use Core\Error\Error;
use Core\Form\Type\ChoiceType;
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
            $this->table = $table;
        }
        $this->form = $form;
    }

    public function getError($xml)
    {
        $error = new Error();

        if (!empty($this->table)) {
            $properties = $this->app->getProperties($this->table::class);
        }

        foreach ($this->form['input'] as $inputs) {
            foreach ($inputs as $value) {
                $inputType = $value['type'];
                $input = str_replace("[]", '', $value['name']);
                if (!isset($_POST[$input]) && !isset($_FILES[$input])) {
                    if ($inputType == SubmitType::class) {
                        continue;
                    }
                    $error->danger("error occured", "error_container");
                }
                if (empty($_POST[$input]) && empty($_FILES[$input])) {
                    if ($inputType == SubmitType::class && $inputType == FileType::class) {
                        continue;
                    };
                    $error->danger("veuillez remplir le champs $input", $input);
                } else if (!empty($this->table)) {
                    $classType = new $inputType();
                    if ($input == "id") {
                        if (!isset($_POST['id']) || !$this->table->findOneBy(['id' => $_POST['id']])) {
                            $error->danger("error occured", "error_container");
                        }
                    } else if ($inputType == ChoiceType::class) {
                        if (!$classType->isInTable($_POST[$input], isset($value['options']['table']) ? $value['options']['table'] : "")) {
                            $error->danger("error occured", "error_container");
                        }
                    } else {
                        if (!$classType->isValid(isset($_POST[$input]) ? $_POST[$input] : $_FILES[$input])) {
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
        }

        return $error;
    }
}
