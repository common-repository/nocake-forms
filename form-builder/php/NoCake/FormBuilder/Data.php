<?php

namespace NoCake\FormBuilder;

class Data implements \Iterator
{
    protected $data = [];

    public function __construct(array $data, array $files = [])
    {
        $this->set($data);
        $this->setFiles($files);
    }

    public function setFiles(array $files)
    {
        // Normalize $_FILES array.
        $arr = [];
        foreach ($files as $fileName => $file) {
            if (is_array($file['name'])) {
                for ($i = 0; $i < count($file['name']); $i++) {
                    foreach ($file as $key => $value) {
                        $arr[$fileName][$i][$key] = $value;
                    }
                }
            } else {
                $arr[$fileName][$fileName] = $file;
            }
        }

        foreach ($arr as $fileName => $file) {
            $this->add($fileName, $file);
        }
    }

    public function set(array $data)
    {
        $this->data = $data;
    }

    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function add($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function remove($key)
    {
        unset($this->data[$key]);
    }

    protected $position = 0;

    /**
     * @inheritDoc
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return key($this->data) !== null;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        reset($this->data);
    }
}
