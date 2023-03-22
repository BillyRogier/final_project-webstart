<?php

namespace Core\Form;

interface FormViewInterface extends FormInterface
{
    /**
     * Retourne une input html
     */
    public function createInput(string $name, $type, string $options): string;

    /**
     * Retourne le formulaire html
     */
    public function getView(): string;
}
