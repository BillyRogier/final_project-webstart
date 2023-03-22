<?php

namespace Core\Form\Type;

class PasswordType extends Type
{
    public function getType()
    {
        return 'password';
    }

    public function getTag($name, $options)
    {
        return parent::input($name, 'password', $options);
    }
}
