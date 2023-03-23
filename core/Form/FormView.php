<?php

namespace Core\Form;

use Core\Form\Type\TextareaType;

class FormView extends Form implements FormViewInterface
{
    public function __construct($form)
    {
        $this->form = $form;
    }

    private function getOptions(array $array, $textarea = false): string
    {
        $array_transform = "";
        foreach ($array as $cle => $value) {
            if ($textarea == true) {
                continue;
            } else {
                $array_transform .= $cle . " = " . "\"$value\"";
            }
        }
        return $array_transform;
    }

    public function viewInput($label, $input)
    {
        return
            "<div class=\"input-container grid\">
                $label
                $input
                <ul class=\"error-message\"></ul>
            </div>";
    }

    public function createAllInput()
    {
        $inputContainer = "";
        foreach ($this->form['input'] as $input) {
            $type = new $input['type']();
            $name = $input['name'];
            if (isset($input['options']['value']) && $type::class == TextareaType::class) {
                $options = $this->getOptions($input['options'], true);
                $input = $type->getTag($name, $input['options']['value'], $options);
            } else {
                $options = $this->getOptions($input['options']);
                $input = $type->getTag($name, $options);
            }
            $label = $type->label(ucfirst($name));
            $inputContainer .= $this->viewInput($label, $input);
        }
        return $inputContainer;
    }

    public function createFormView()
    {
        return
            "
        <form action=\"" . $this->form['action'] . "\" method=\"" . $this->form['method'] . "\" " . $this->getOptions($this->form['options']) . ">
            " . $this->createAllInput() . "
        </form>    
        ";
    }

    public function getView()
    {
        return $this->createFormView();
    }
}
