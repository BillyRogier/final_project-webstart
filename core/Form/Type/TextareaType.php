<?php

namespace Core\Form\Type;

class TextareaType extends Type
{
    public function getTag($name, $value = "", $options = [])
    {
        return parent::textarea($name, $value, $options);
    }
}
