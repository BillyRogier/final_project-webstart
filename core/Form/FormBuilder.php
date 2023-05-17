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
        if (isset($this->form['input'][$name])) {
            array_push($this->form['input'][$name], ['name' => $name, 'type' => $type, 'options' => $options]);
        } else {
            $this->form['input'][$name] = [];
            array_push($this->form['input'][$name], ['name' => $name, 'type' => $type, 'options' => $options]);
        }
        return $this;
    }

    public function addContainer(string $name, array $array): FormBuilderInterface
    {
        $id = uniqid();
        $this->form['input'][$id] = [];
        foreach ($array as $value) {
            $input_name = isset($value[0]) ? $value[0] : "";
            $type = isset($value[1]) ? $value[1] : "";
            $options = isset($value[2]) ? $value[2] : [];
            array_push($this->form['input'][$id], ['name' => $input_name, 'type' => $type, 'options' => $options]);
        }
        return $this;
    }

    public function addHTML(string $html): FormBuilderInterface
    {
        $id = uniqid();
        $this->form['input'][$id] = [];
        array_push($this->form['input'][$id], ["html" => $html]);
        return $this;
    }

    public function change(string $name, array $options = [], int $key = 0): FormBuilderInterface
    {
        $previousInput = $this->form['input'][$name][$key];
        $this->form['input'][$name][$key] = ['name' => $name, 'type' => $previousInput['type'],  'options' => $options];
        return $this;
    }
}
