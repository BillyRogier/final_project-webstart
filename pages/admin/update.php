<ul class="error-container"></ul>
<?php

use Core\Form\Type\HiddenType;

foreach ($carousel as $key => $value) {
    if ($key == 0) {
        $form_update
            ->change("img[]", ['value' => $value->getImg()]);
    } else {
        $form_update
            ->add("img[]", HiddenType::class, ['value' => $value->getImg()]);
    }
}

echo $form_update->createView()

?>