<?php

namespace Core\Form\Type;

class SubmitType extends Type
{
    public function label($name)
    {
        return "";
    }

    public function getTag($name, $options)
    {
        return parent::input($name, 'submit', $options);
    }
}
