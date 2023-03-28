<?php

namespace Core\Form\Type;

class FileType extends Type
{
    // public function isValid($value)
    // {
    //     // if (!preg_match("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i", $value)) {
    //     //     return false;
    //     // }
    //     // return true;
    // }

    public function getTag($name, $options)
    {
        return parent::input($name, 'file', $options);
    }
}
