<?php

namespace Core\Form\Type;

class TextType extends Type
{
    public function getTag($name, $options)
    {
        return parent::input($name, 'text', $options);
    }
}
