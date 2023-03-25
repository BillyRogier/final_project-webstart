<?php

namespace Core\Form\Type;

class ChoiceType extends Type
{

    public function isInTable($value, $table)
    {
        if (!$table->findOneBy(['category_id' => $value])) {
            return false;
        }
        return true;
    }

    public function getTag($name, $options = [], $options_choice = [])
    {
        $options_container = "";
        if (isset($options_choice)) {
            foreach ($options_choice as $name_choice => $value) {
                $options_container .= parent::options($name_choice, $value);
            }
        }
        return parent::select($name, $options, $options_container);
    }
}
