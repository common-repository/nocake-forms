<?php

namespace NoCake\FormBuilder\Control;

use NoCake\FormBuilder\AbstractControl;
use NoCake\FormBuilder\Form;

class Cnt extends AbstractControl
{
    public function __construct(array $def, Form $form)
    {
        parent::__construct($def, $form);

        for ($i = 1; $i <= $def['cols']; $i++) {
            $items = $def['items'][$i-1];
            $form->traverse($items);
        }
    }

    public function validateDefinition()
    {
        return true;
    }

    public function validate()
    {
        return true;
    }
}
