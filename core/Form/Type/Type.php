<?php

namespace Core\Form\Type;

class Type
{
    public function label($name)
    {
        $name = strtolower(str_replace("[]", '', $name));
        return "<label for=\"" . $name . "\">$name</label>";
    }

    public function isValid($value)
    {
        return true;
    }

    function input($name, $type, $options)
    {
        if (str_contains($name, '[]')) {
            $name = strtolower(str_replace("[]", '', $name));
            return  "<div class=\"$name-item\"><input 
            name=\"$name\" 
            class=\"$name\" 
            type=\"$type\" 
            $options
        ></div>";
        } else {
            return  "<input 
                name=\"$name\" 
                class=\"$name\" 
                type=\"$type\" 
                $options
            >";
        }
    }

    function textarea($name, $value, $options)
    {
        return
            "<textarea
                name=\"$name\" 
                class=\"" . strtolower(str_replace("[]", '', $name)) . "\" 
                $options>$value</textarea>";
    }

    function options($name, $value)
    {
        return
            "<option
                value=\"$value\">$name</option>";
    }

    function select($name, $select_option, $options)
    {
        return
            "<select
                name=\"$name\" 
                class=\"" . strtolower(str_replace("[]", '', $name)) . "\" 
                $select_option>$options</select>";
    }
}
