<?php

namespace Core\Form;

use Core\Form\Type\ChoiceType;
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
            if ($textarea == true && ($cle == "value" || $cle == "choices" || $cle == "table")) {
                continue;
            } else {
                $array_transform .= $cle . " = " . "\"$value\"";
            }
        }
        return $array_transform;
    }

    public function viewInput($label, $input, $name)
    {
        return
            "<div class=\"input-container $name-container grid\">
                $label
                $input
                <ul class=\"error-message\"></ul>
            </div>";
    }

    public function createAllInput()
    {
        $inputContainer = "";
        foreach ($this->form['input'] as $input) {
            foreach ($input as $value) {
                $type = new $value['type']();
                $name = $value['name'];
                if (isset($value['options']['value']) && $type::class == TextareaType::class) {
                    $options = $this->getOptions($value['options'], true);
                    $value = $type->getTag($name, $value['options']['value'], $options);
                } else if (isset($value['options']['choices']) && $type::class == ChoiceType::class) {
                    $options = $this->getOptions($value['options'], true);
                    $value = $type->getTag($name, $options, $value['options']['choices']);
                } else {
                    $options = $this->getOptions($value['options']);
                    $value = $type->getTag($name, $options);
                }
                $label = $type->label(ucfirst($name));
                $inputContainer .= $this->viewInput($label, $value, strtolower(str_replace("[]", '', $name)));
            }
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
