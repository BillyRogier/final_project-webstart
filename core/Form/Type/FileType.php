<?php

namespace Core\Form\Type;

class FileType extends Type
{
    public function label($name, $for)
    {
        $for = str_replace("[]", '', $for);
        return "<label for=\"" . $for . "\" class=\"file-label\"> <div class=\"arrow\"><img src=\"" . BASE_PUBLIC . "/assets/icon/plus.svg\" alt=\"ajouter un fichier\"></div>" . ucfirst($name) . "</label>";
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'file', $options, $options_html);
    }
}
