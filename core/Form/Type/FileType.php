<?php

namespace Core\Form\Type;

class FileType extends Type
{
    public function label($name, $for)
    {
        $for = str_replace("[]", '', $for);
        return "<label for=\"" . $for . "\">" . ucfirst($name) . "</label>";
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'file', $options, $options_html);
    }
}
