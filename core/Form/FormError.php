<?php

namespace Core\Form;

use App;
use Core\Error\Error;
use Core\Form\Type\ChoiceType;
use Core\Form\Type\FileType;
use Core\Form\Type\PasswordType;
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

        if (
            !empty($_POST['csrf_token']) &&
            $_POST['csrf_token'] === $_SESSION['csrf_token']
        ) {
            if (!empty($this->table)) {
                $properties = $this->app->getProperties($this->table::class);
            }

            foreach ($this->form['input'] as $inputs) {
                foreach ($inputs as $value) {
                    if (isset($value['type'])) {
                        $inputType = $value['type'];
                        $input = str_replace("[]", '', $value['name']);
                        if (!isset($_POST[$input]) && !isset($_FILES[$input])) {
                            if ($inputType == SubmitType::class) {
                                continue;
                            }
                            $error->danger("Une erreur est survenue", "error_container");
                        } else if ((isset($_POST[$input]) ? is_array($_POST[$input]) : is_array($_FILES[$input]))) {
                            foreach ((isset($_POST[$input]) ? $_POST[$input] : $_FILES[$input]) as $vals) {
                                if (empty($vals) && !isset($value['options']['data-req'])) {
                                    if ($inputType == SubmitType::class || $inputType == FileType::class || $input == "id") {
                                        continue;
                                    };
                                    $error->danger("veuillez remplir le champs " . (isset($value['options']['label']) ? $value['options']['label'] : $input) . "", $input);
                                }
                            }
                        }
                        if (empty($_POST[$input]) && empty($_FILES[$input])  && !isset($value['options']['data-req'])) {
                            if ($inputType == SubmitType::class || $inputType == FileType::class || $input == "id") {
                                continue;
                            };
                            $error->danger("veuillez remplir le champs " . (isset($value['options']['label']) ? $value['options']['label'] : $input) . "", $input);
                        } else if (!empty($this->table)) {
                            if ($inputType != ChoiceType::class && (($inputType == PasswordType::class) ? isset($value['options']['data-pass']) : true)) {
                                $classType = new $inputType();
                                if (!$classType->isValid(isset($_POST[$input]) ? $_POST[$input] : $_FILES[$input])) {
                                    $error->danger("le champs " . (isset($value['options']['label']) ? $value['options']['label'] : $input) . " doit être de type " . $properties[$input]->getType() . "", $input);
                                }
                                if (isset($properties[$input]) && !empty($properties[$input]->getLenght())) {
                                    if (is_array($_POST[$input])) {
                                        foreach ($_POST[$input] as $value) {
                                            if (strlen($value) > $properties[$input]->getLenght()) {
                                                $error->danger("le champs " . (isset($value['options']['label']) ? $value['options']['label'] : $input) . " doit contenir maximum " . $properties[$input]->getLenght() . "", $input);
                                            }
                                        }
                                    } else {
                                        if (strlen($_POST[$input]) > $properties[$input]->getLenght()) {
                                            $error->danger("le champs " . (isset($value['options']['label']) ? $value['options']['label'] : $input) . " doit contenir maximum " . $properties[$input]->getLenght() . "", $input);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $error->danger("Une erreur est survenue", "error_container");
        }
        return $error;
    }
}
