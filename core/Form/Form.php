<?php

namespace Core\Form;

class Form implements FormInterface
{
    protected $form;

    public function createForm(string $action = "", string $method = "post", array $options = []): FormBuilder
    {
        $formBuilder = new FormBuilder($action, $method, $options);
        return $formBuilder;
    }

    public function createView(): string
    {
        $formView = new FormView($this->form);
        return $formView->getView();
    }

    public function getForm(): FormInterface
    {
        return $this;
    }

    public function isSubmit(): bool
    {
        if (!isset($_POST) || empty($_POST)) {
            return false;
        }
        return true;
    }

    public function isXmlValid($table = "")
    {
        $error = new FormError($this->form, $table);
        return $error->getError(true);
    }

    public function isValid($table = "")
    {
        $error = new FormError($this->form, $table);
        return $error->getError(false);
    }

    public function getData(): array
    {
        $array = [];
        foreach ($_POST as $cle => $value) {
            $array[$cle] = htmlspecialchars($value);
        }
        foreach ($_FILES as $cle => $value) {
            $array[$cle] = $value;
        }
        return $array;
    }
}
