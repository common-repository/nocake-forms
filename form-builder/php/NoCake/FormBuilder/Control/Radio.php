<?php

namespace NoCake\FormBuilder\Control;

use NoCake\FormBuilder\AbstractControl;
use NoCake\FormBuilder\Exception\ValidationException;

class Radio extends AbstractControl
{
    public function validateDefinition()
    {
        return true;
    }

    public function validate()
    {
        $value = $this->getValue();
        $items = $this->def['items'];
        $error = null;

        if ($this->isRequired() and $this->isEmpty($value)) {
            $error = 'required';
            goto exception;
        }

        foreach ($items as $item) {
            if ($item['uid'] === $value) {
                return true;
            }
        }

        if ($this->isRequired()) {
            $error = 'required';
            goto exception;
        }
        
	    exception:
		    if ($error !== null) {
			    $errors = [];
			    $errKey = $this->def['type'].'.';
			    $errors[$this->getUid()] =
				    is_array($error) ?
					    array_merge([$errKey.$error[0]], array_slice($error, 1)) :
					    $errKey.$error;
			
			    throw ValidationException::create($errors);
		    }
	
	    $this->form->addData($this->getUid(), $value);
	
	    return true;
    }
}