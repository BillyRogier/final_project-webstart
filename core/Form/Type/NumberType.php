<?php

namespace Core\Form\Type;

class NumberType extends Type
{
    public function isValid($value)
    {
        $resp = true;
        if (is_array($value)) {
            foreach ($value as $val) {
                if (!preg_match('/^-?(?:\d+|\d*\.\d+)$/', $val)) {
                    $resp = false;
                }
            }
        } else {
            if (!preg_match('/^-?(?:\d+|\d*\.\d+)$/', $value)) {
                $resp = false;
            }
        }
        return $resp;
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'text', $options, $options_html);
    }
}
