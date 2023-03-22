<?php

namespace Core\Form\Type;

class TextareaType extends Type
{
    public function getTag($name, $options)
    {
        return parent::textarea($name, $options);
    }
}
