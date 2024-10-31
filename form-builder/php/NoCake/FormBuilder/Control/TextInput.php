<?php

namespace NoCake\FormBuilder\Control;

use NoCake\FormBuilder\AbstractControl;
use NoCake\FormBuilder\Exception\ValidationException;

class TextInput extends AbstractControl
{
    public function validateDefinition()
    {
        return true;
    }

    public function validate()
    {
        $value = $this->getValue();
        $valueType = $this->def['valueType'];

        $value = trim($value);

        $error = null;

        if ($this->isRequired() and $this->isEmpty($value)) {
            $error = 'required';
            goto exception;
        }

        if ($this->isEmpty($value)) {
            goto addData;
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
            case 'int':
                if (!preg_match('/^[0-9]+$/', $value)) {
                    $error = 'not_int';
                    goto exception;
                }

                $value = (int) $value;

                if ($value < (int) $this->def['valueTypeCfg']['int']['min']) {
                    $error = ['too_low', $this->def['valueTypeCfg']['int']['min']];
                    goto exception;
                }

                if ($value > (int) $this->def['valueTypeCfg']['int']['max']) {
                    $error = ['too_high', $this->def['valueTypeCfg']['int']['max']];
                    goto exception;
                }
                break;
            case 'num':
                if (!preg_match('/^[0-9]+([,\.][0-9]+)?$/', $value)) {
                    $error = 'not_num';
                    goto exception;
                }

                $value = (float) str_replace(',', '.', $value);

                if ($value < (int) $this->def['valueTypeCfg']['num']['min']) {
                    $error = ['too_low', $this->def['valueTypeCfg']['num']['min']];
                    goto exception;
                }

                if ($value > (int) $this->def['valueTypeCfg']['num']['max']) {
                    $error = ['too_high', $this->def['valueTypeCfg']['num']['max']];
                    goto exception;
                }
                break;
            case 'decimal':
                if (!preg_match('/^[0-9]+[,\.][0-9]+$/', $value)) {
                    $error = 'not_decimal';
                    goto exception;
                }

                $value = str_replace(',', '.', $value);

                list($a, $decimal) = explode('.', $value);
                $decCount = strlen($decimal);
                if ($decCount < $this->def['valueTypeCfg']['decimal']['minDec']) {
                    $error = ['too_low_decimal', $this->def['valueTypeCfg']['decimal']['minDec']];
                    goto exception;
                }

                if ($decCount > $this->def['valueTypeCfg']['decimal']['maxDec']) {
                    $error = ['too_high_decimal', $this->def['valueTypeCfg']['decimal']['maxDec']];
                    goto exception;
                }

                $value = (float) $value;

                if ($value < (int) $this->def['valueTypeCfg']['decimal']['min']) {
                    $error = ['too_low', $this->def['valueTypeCfg']['decimal']['min']];
                    goto exception;
                }

                if ($value > (int) $this->def['valueTypeCfg']['decimal']['max']) {
                    $error = ['too_high', $this->def['valueTypeCfg']['decimal']['max']];
                    goto exception;
                }
                break;
            case 'firstName':
                if (mb_strlen($value) < 2) {
                    $error = ['too_short', 2];
                    goto exception;
                }

                if (!preg_match('/^[\w\'\-,.][^0-9_!¡?÷?¿\/\\\\+=@#$%ˆ&*(){}|~<>;:\[\]]{1,}$/i', $value)) {
                    $error = 'not_first_name';
                    goto exception;
                }

                if (mb_strlen($value) > 40) {
                    $error = ['too_long', 40];
                    goto exception;
                }
                break;
            case 'lastName':
                if (mb_strlen($value) < 2) {
                    $error = ['too_short', 2];
                    goto exception;
                }

                if (!preg_match('/^[\w\'\-,.][^0-9_!¡?÷?¿\/\\\\+=@#$%ˆ&*(){}|~<>;:\[\]]{1,}$/i', $value)) {
                    $error = 'not_last_name';
                    goto exception;
                }

                if (mb_strlen($value) > 40) {
                    $error = ['too_long', 40];
                    goto exception;
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $error = 'not_email';
                    goto exception;
                }
                break;
	        case 'phone':
		        if (!preg_match("/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/i", $value)) {
			        $error = 'not_phone';
			        goto exception;
		        }
	        	break;
	        case 'zipCode':
		        if (!preg_match("/^[0-9]{2}(-)?[0-9]{3}([- ]?[0-9]{4})?$/", $value)) {
			        $error = 'not_zip_code';
			        goto exception;
		        }
		        break;
            case 'url':
                if (!preg_match('/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:\/\?#[\]@!\$&\'\(\)\*\+,;=.]+$/i', $value)) {
                    $error = 'not_url';
                    goto exception;
                }
                break;
            default:
                throw new \Exception('Unsuported value type.');
        }

        exception:
            if ($error !== null) {
                $errors = [];
                $errKey = 'textInput.'.$this->def['valueType'].'.';
                $errors[$this->getUid()] =
                    is_array($error) ?
                    array_merge([$errKey.$error[0]], array_slice($error, 1)) :
                    $errKey.$error;

                throw ValidationException::create($errors);
            }

        addData:
            $this->form->addData($this->getUid(), $value);

            return true;
    }
}
