<?php

namespace Core\Form\Type;

use DateTime;

class DateTimeType extends Type
{
    public function isValid($value)
    {
        $format = 'Y-m-d\TH:i:s';
        $d = DateTime::createFromFormat($format, $value);
        if ($d && $d->format($format) == $value) {
            return true;
        }
        return false;
    }

    public function getMessage()
    {
        return "Le format de la date est incorrect";
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'datetime-local', $options,  $options_html);
    }
}
