<?php

namespace Core\Form;

class FormBuilder extends Form implements FormBuilderInterface
{
    public function __construct(string $action = "", string $method = "post", array $options = [])
    {
        $this->form = ['action' => $action, 'method' => $method, 'options' => $options];
    }

    public function add(string $name, string $type = "text", array $options = []): FormBuilderInterface
    {
        $this->form['input'][$name] = ['name' => $name, 'type' => $type, 'options' => $options];
        return $this;
    }

    public function change(string $name, array $options = []): FormBuilderInterface
    {
        $previousInput = $this->form['input'][$name];
        $this->form['input'][$name] = ['name' => $name, 'type' => $previousInput['type'],  'options' => $options];
        return $this;
    }
}
