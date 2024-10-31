<?php

namespace NoCake\FormBuilder;

abstract class AbstractControl
{
    /**
     * @var Form
     */
    protected $form;

    protected $def;

    public function __construct(array $def, Form $form)
    {
        $this->def = $def;
        $this->form = $form;
    }

    abstract public function validateDefinition();

    abstract public function validate();

    /**
     * Name used as identification of this control.
     * @return string
     */
    public function getName()
    {
        return isset($this->def['name']) ? $this->def['name'] : (isset($this->def['label']) ? $this->def['label'] : '@'.$this->def['type']);
    }

    /**
     * Return controls value.
     * @return mixed
     */
    public function getValue()
    {
        return $this->form->getData()->get($this->getUid());
    }

    public function getUid()
    {
        return $this->def['uid'];
    }

    public function getType()
    {
        return explode('.', $this->def['type'])[0];
    }

    public function getSubtype()
    {
        return explode('.', $this->def['type'])[1];
    }

    public function isRequired()
    {
        return (isset($this->def['required']) and $this->def['required']);
    }

    public function isEmpty($value)
    {
        return ($value === '' or $value === null or (is_array($value) and count($value) === 0));
    }

    public function isOnList()
    {
        return (isset($this->def['onList']) ? (bool) $this->def['onList'] : false);
    }
}
