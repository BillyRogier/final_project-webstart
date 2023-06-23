<?php

namespace Core\Form\Type;

class Type
{
    public function label($name, $for)
    {
        return "<label for=\"" . $for . "\">" . ucfirst($name) . "</label>";
    }

    public function isValid($value)
    {
        return true;
    }

    function input($name, $type, $options, $options_html)
    {
        $nameControl = strtolower(str_replace("[]", '', $name));
        $input = "<input name=\"$name\" type=\"$type\" $options> ";
        if ($name == "quantity") {
            $input = "
            <p class=\"less\">-</p>
            <input name=\"$name\" type=\"$type\" $options> 
            <p class=\"more\">+</p>
            ";
        } else if ($name == "delete_btn") {
            $input = "
            <input name=\"$name\" type=\"$type\" $options> 
            <img src=\"" . BASE_PUBLIC . "/assets/icon/bin.svg\"/>
            ";
        }

        return
            "<div class=\"$nameControl-item\">
                $input
                $options_html
            </div>";
    }

    function textarea($name, $value, $options)
    {
        return
            "<div class=\"$name-item\"><textarea
                name=\"$name\" 
                $options>$value</textarea></div>";
    }

    function options($name, $value, $select = "")
    {
        if ($select == true) {
            $select = "selected";
        }
        return
            "<option
                value=\"$value\" $select>$name</option>";
    }

    function select($name, $select_option, $options, $options_html)
    {
        $nameControl = strtolower(str_replace("[]", '', $name));
        return
            "<div class=\"$nameControl-item\">
            <select name=\"$name\" id=\"$name\"
                $select_option>$options</select></div> $options_html";
    }
}
