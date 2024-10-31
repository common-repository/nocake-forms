<?php

namespace NoCake\FormBuilder\Control;

use NoCake\FormBuilder\AbstractControl;
use NoCake\FormBuilder\Exception\ValidationException;

class Checkbox extends AbstractControl
{
    public function validateDefinition()
    {
        return true;
    }

    public function validate()
    {
        $values = $this->getValue();
        $items = $this->def['items'];
        $error = null;

        if ($this->isRequired() and $this->isEmpty($values)) {
            $error = 'required';
            goto exception;
        }

        if (!$this->isRequired() and $this->isEmpty($values)) {
            return true;
        }

        if (!is_array($values)) {
            $error = 'bad_value';
            goto exception;
        }

        $uids = [];
        foreach ($items as $item) {
            $uids[] = $item['value'];
        }

        foreach ($values as $value) {
            if (!in_array($value, $uids)) {
                $error = 'bad_value';
                goto exception;
            }
        }

        if ($this->isRequired() and !$values) {
            $error = 'required';
            goto exception;
        }

        if (!$error) {
            $this->form->addData($this->getUid(), $values);
            return true;
        }

        exception:
            $exception = new ValidationException();
            $errors = [];
            $errors[$this->getUid()] = $this->def['type'].'.'.$error;
            $exception->setErrors($errors);
            throw $exception;
    }
}