<?php

namespace Core\Form\Type;

class Type
{
    public function label($name)
    {
        return "<label for=\"" . strtolower($name) . "\">$name</label>";
    }

    public function isValid($value)
    {
        return true;
    }

    function input($name, $type, $options)
    {
        return
            "<input 
                name=\"$name\" 
                id=\"$name\" 
                type=\"$type\" 
                $options
            >";
    }

    function textarea($name, $value, $options)
    {
        return
            "<textarea
                name=\"$name\" 
                id=\"$name\" 
                $options>$value</textarea>";
    }
}
