<?php

namespace NoCake\FormBuilder\Control;

use NoCake\FormBuilder\AbstractControl;
use NoCake\FormBuilder\Exception\ValidationException;

class TextArea extends AbstractControl
{
    public function validateDefinition()
    {
        return true;
    }

    public function validate()
    {
        $value = $this->getValue();
        $valueType = $this->def['valueType'];
        $error = null;

        if ($this->isRequired() and $this->isEmpty($value)) {
            $error = 'required';
            goto exception;
        }

        switch ($valueType) {
	        case 'any':
                $valueLen = mb_strlen($value);

		        if ($valueLen < (int) $this->def['valueTypeCfg']['any']['min']) {
			        $error = ['too_low', $this->def['valueTypeCfg']['any']['min']];
			        goto exception;
		        }

		        if ($valueLen > (int) $this->def['valueTypeCfg']['any']['max']) {
			        $error = ['too_high', $this->def['valueTypeCfg']['any']['max']];
			        goto exception;
		        }
		        break;
	        default:
		        throw new \Exception('Unsuported value type.');
        }

	    exception:
		    if ($error !== null) {
			    $errors = [];
			    $errKey = 'textArea.'.$this->def['valueType'].'.';
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
