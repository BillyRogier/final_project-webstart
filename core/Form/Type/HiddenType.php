<?php

namespace Core\Form\Type;

class HiddenType extends Type
{
    public function label($name)
    {
        return "";
    }

    public function getTag($name, $options)
    {
        return parent::input($name, 'hidden', $options);
    }
}
