<?php

namespace Core\Form;

class FormView extends Form implements FormViewInterface
{
    public function __construct($form)
    {
        $this->form = $form;
    }

    private function getOptions(array $array): string
    {
        $array_transform = "";
        foreach ($array as $cle => $value) {
            $array_transform .= $cle . " = " . "\"$value\"";
        }
        return $array_transform;
    }

    public function createInput(string $name, $type, string $options): string
    {
        $label = $type->label(ucfirst($name));
        $input = $type->getTag($name,  $options);
        return
            "<div class=\"input-container grid\">
                $label
                $input
                <ul class=\"error-message\"></ul>
            </div>";
    }

    public function getView(): string
    {
        $inputContainer = "";
        foreach ($this->form['input'] as $input) {
            $type = new $input['type']();
            $inputContainer .= $this->createInput($input['name'], $type, $this->getOptions($input['options']));
        }
        return
            "
        <form action=\"" . $this->form['action'] . "\" method=\"" . $this->form['method'] . "\" " . $this->getOptions($this->form['options']) . ">
            $inputContainer
        </form>    
        ";
    }
}
