<?php

namespace Core\Form\Type;

class PasswordType extends Type
{

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'password', $options, $options_html);
    }
}
