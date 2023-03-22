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

    public function isValid(string $table = ""): bool
    {
        $error = new FormError($this->form, $table);
        if (empty($table)) {
            return $error->getError();
        }
        return $error->getTableError();
    }

    public function getData(): array
    {
        $array = [];
        foreach ($_POST as $cle => $value) {
            $array[$cle] = htmlspecialchars($value);
        }
        return $array;
    }
}
