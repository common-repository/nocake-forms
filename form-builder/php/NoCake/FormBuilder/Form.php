<?php

namespace NoCake\FormBuilder;

use NoCake\FormBuilder\Control\Checkbox;
use NoCake\FormBuilder\Control\Cnt;
use NoCake\FormBuilder\Control\File;
use NoCake\FormBuilder\Control\Radio;
use NoCake\FormBuilder\Control\Select;
use NoCake\FormBuilder\Control\TextArea;
use NoCake\FormBuilder\Control\TextInput;
use NoCake\FormBuilder\Exception\ControlDataProcessingException;
use NoCake\FormBuilder\Exception\ValidationException;

class Form
{
    /**
     * Form definition.
     * @var array
     */
    protected $def;

    /**
     * Data to process.
     * @var AbstractData
     */
    protected $data;

    /**
     * Uploaded files.
     * @var AbstractData
     */
    protected $files;

    /**
     * Array of controls instances.
     * @var array
     */
    protected $controls = [];

    protected $errorMsgs = [];

    /**
     * Additional config mainly used by controls.
     * @var array
     */
    protected $config = [];

    protected $controlsClasses = [
        'textInput.firstName' => TextInput::class,
        'textInput.lastName' => TextInput::class,
        'textInput.textInput' => TextInput::class,
        'textInput.email' => TextInput::class,
        'textInput.phone' => TextInput::class,
        'textInput.zipCode' => TextInput::class,
        'textInput.url' => TextInput::class,
        'textInput.int' => TextInput::class,
        'textInput.num' => TextInput::class,
        'textInput.decimal' => TextInput::class,
        'cnt.cnt' => Cnt::class,
        'cnt.two' => Cnt::class,
        'cnt.three' => Cnt::class,
        'cnt.four' => Cnt::class,
        'file.file' => File::class,
        'file.image' => File::class,
        'file.docs' => File::class,
        'radio.radio' => Radio::class,
        'select.select' => Select::class,
        'textArea.textArea' => TextArea::class,
        'checkbox.checkbox' => Checkbox::class
    ];

    /**
     * @var array
     */
    protected $processedData = [];

    /**
     * Form constructor.
     * @param array $def Form definition.
     * @param array $data
     * @param array $controlsClasses
     * @param array $config
     */
    public function __construct(array $def, $data = null, array $config = [], array $controlsClasses = [])
    {
        $this->def = $def;
        $this->controlsClasses = array_merge($this->controlsClasses, $controlsClasses);
        $this->data = $data ? $data : new Data([]);
        $this->config = $config;
        $this->traverse(isset($def['items']) ? $def['items'] : []);
    }

    public function setData(AbstractControl $data)
    {
        $this->data = $data;
    }

    public function setErrorMessages(array $messages)
    {
        $this->errorMsgs = $messages;
    }

    /**
     * Validate form definition.
     */
    public function validateDefinition()
    {

    }

    public function process()
    {
        $errors = $this->validate();

        if ($errors) {
            $exception = new ValidationException();
            $exception->setErrors($errors);
            throw $exception;
        }
    }

    public function validate()
    {
        $errors = [];

        try {
            foreach ($this->getControls() as $control) {
                try {
                    $control->validate();
                } catch (ValidationException $e) {
                    // Do not use array_merge because it does not respect integer keys.
                    foreach ($e->getErrors() as $uid => $error) {
                        $errors[$uid] = $error;
                    }
                }
            }
        } catch (ControlDataProcessingException $e) {
            $errors['_'] = $e->getMessage();
        }

        foreach ($errors as $key => $error) {
            $errors[$key] = $this->getErrorMessage($error);
        }

        return $errors;
    }

    public function getErrorMessage($error)
    {
        $messages = $this->errorMsgs;
        if (is_array($error)) {
            $tmp = $error[0];
            $args = array_slice($error, 1);
            $error = $tmp;
        } else {
            $args = [];
        }
        $parts = explode('.', $error);
        $last = count($parts) - 1;
        $i = 0;

        foreach ($parts as $part) {
            if (isset($messages[$part])) {
                if ($i == $last) {
                    if ($args) {
                        array_unshift($args, $messages[$part]);
                        return call_user_func_array('sprintf', $args);
                    }
                    return $messages[$part];
                } else {
                    $messages = $messages[$part];
                }
            } else {
                return $error;
            }

            $i++;
        }

        return $error;
    }

    /**
     * @param integer $uid Control uid.
     * @return AbstractControl
     */
    public function getControlByUid($uid)
    {
        if (isset($this->controls[$uid])) {
            return $this->controls[$uid];
        }

        throw new \InvalidArgumentException('Control with uid "'.$uid.'" does not exists.');
    }

    /**
     * @return AbstractControl[]
     */
    public function getControls()
    {
        return $this->controls;
    }

    public function traverse(array $items)
    {
        foreach ($items as $control) {
            $uid = $control['uid'];
            if (!isset($this->controls[$uid])) {
                $type = $control['type'];

                if (!isset($this->controlsClasses[$type])) {
                    continue;
                }

                $class = $this->controlsClasses[$type];
                $ctrl = new $class($control, $this);
                $this->controls[$uid] = $ctrl;
            }
        }
    }

    public function addControl($uid, AbstractControl $control)
    {
        $this->controls[$uid] = $control;
    }

    public function getControlsClasses()
    {
        return $this->controlsClasses;
    }

    public function addData($key, $value)
    {
        $this->data->add($key, $value);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Return email_delivery config.
     * @return array
     */
    public function getEmailDeliveryConfig()
    {
        $def = $this->def;

        $table = '';
        $data = $this->getData();
        foreach ($data as $controlUid => $value) {
            $ctrl = $this->getControlByUid($controlUid);
            $name = $ctrl->getName();

            if ($ctrl->getType() == 'file') {
                // @todo handle files.
                continue;
            }

            switch ($ctrl->getType()) {
                case 'file':
                    // @todo handle files.
                    break;
                case 'checkbox':
                case 'radio':
                    $values = implode(', ', array_map(function($value) { return htmlentities(strip_tags($value)); }, (array) $value));

                    $table .= "
                        <tr>
                            <th>{$name}</th>
                            <td>{$values}</td>
                        </tr>
                    ";
                    break;
                default:
                    $value = htmlentities(strip_tags($value));
                    $table .= "
                        <tr>
                            <th>{$name}</th>
                            <td>{$value}</td>
                        </tr>
                    ";
                    break;
            }
        }
        $table = "<table>{$table}</table>";

        $config = array_merge([
            'emails' => [],
            'subject' => 'New form submission',
            'message' => "
                <div>
                    <p>New form submission:</p>
                    %submission%
                </div>
            "
        ], isset($def['emailDelivery']) ? $def['emailDelivery'] : []);

        $config['message'] = str_replace('%submission%', $table, $config['message']);
        $config['message'] = '
            <!doctype html>
            <html>
                <head>
                    <meta name="viewport" content="width=device-width" />
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title></title>
                </head>
                <body>
                    '.$config['message'].'
                </body>
            </html>
        ';

        return $config;
    }

    public function getName()
    {
        return $this->def['name'];
    }

    public function getUid()
    {
        return $this->def['uuid'];
    }

    /**
     * Slugify text.
     *
     * @param string $text
     * @return string
     */
    public function slugify(string $text): string
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);

        return $text;
    }
}
